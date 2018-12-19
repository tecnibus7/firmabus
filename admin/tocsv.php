<?php

  include "data.php";

  $fichero = 'archivo.csv';
  $actual = "Fecha, Hora entrada, Hora salida \n";

  $usuario = $_POST['becario_seleccionado'];
#  $usuario = $_POST['becario'];
  $id_usuario = CSVUsuario($usuario);
  echo "ID: " . $id_usuario . " \n";

#  include "data.php";
  $db_url = 'sqlite:../bd/users.sqlite3';
  $db_connection = new PDO($db_url) or die ("No se ha podido conectar con la BD.");
  $sentencia = $db_connection->prepare("SELECT operacion, fecha, hora, verificacion FROM registro WHERE becario = '$id_usuario'") or die("La sentencia SQL es incorrecta");
  $sentencia->execute();
  $siguiente = "";
  foreach($sentencia as $row){
    switch ($row['operacion']) {
      case 'entrada':
        # code...
        if ($siguiente == 'entrada'){
          $actual .= $row['fecha'] . "," . $row['hora'] . ", , \n";
          $siguiente = "entrada";
        }else{
          $actual .= $row['fecha'] . "," . $row['hora'] . ", ";
#        echo $row['fecha'] . "," . $row['hora'] . ", ";
          $siguiente = "salida";
        }
        break;

      default:
        # code...
        if ($siguiente == 'salida')
          $actual .= $row['hora'] . "\n";
        else
          $actual .= $row['fecha'] . ", , " . $row['hora'] . "\n";
#        echo $row['hora'] . "\n";
        $siguiente = "entrada";
        break;
    }

  }
  $sentencia = null;
  $db_connection = null;


#  $actual .= "26/4/2018, 9:55, 14:02\n";
  file_put_contents($fichero, $actual, LOCK_EX) or die("No se puede escribir el fichero. De permisos de escritura al fichero txt chmod 777");


  header('Content-type: application/csv');
  header('Content-Disposition: attachment; filename="' . $usuario . '.csv"');
  readfile('archivo.csv');
?>
