<?php
  function altaUsuario(){
    $db_url = 'sqlite:../bd/users.sqlite3';
    $db_connection = new PDO($db_url) or die ("No se ha podido conectar con la BD.");

    $identificador_form = $_POST['f_identificador'];
    $apellidos_form = $_POST['f_apellidos'];
    $nombre_form = $_POST['f_nombre'];
    $email_form = $_POST['f_email'];
    $email_control_form = $_POST['f_email_control'];

    $sentencia = $db_connection->prepare("INSERT INTO becarios(identificador, apellidos, nombre, email_user, email_control) VALUES ('$identificador_form', '$apellidos_form', '$nombre_form', '$email_form', '$email_control_form')") or die("La sentencia SQL es incorrecta");
  #  $sentencia->bindValue($identificador_form, $apellidos_form, $nombre_form, $email_form, $email_control_form, PDO::PARAM_INT) or die("No se puede aplicar la entrada.");
    $sentencia->execute();
    $db_connection = null;
  }

  function destroyUser($identificador){
    $db_url = 'sqlite:../bd/users.sqlite3';
    $db_connection = new PDO($db_url) or die ("No se ha podido conectar con la BD.");

    $identificador_user = $_POST['becario_seleccionado'];

    $sentencia = $db_connection->prepare("DELETE FROM becarios WHERE identificador = '$identificador_user'") or die("La sentencia SQL es incorrecta");
  #  $sentencia->bindValue($identificador_form, $apellidos_form, $nombre_form, $email_form, $email_control_form, PDO::PARAM_INT) or die("No se puede aplicar la entrada.");
    $sentencia->execute();
    $db_connection = null;


  }

  function getAllBecarios(){
    $db_url = 'sqlite:../bd/users.sqlite3';
    $db_connection = new PDO($db_url) or die ("No se ha podido conectar con la BD.");

    $result = $db_connection->query("SELECT * FROM becarios");
    foreach($result as $row)
    {
 #      echo $row['origen'] . " " . $row['destino'] . " " . "</br>";
        $res = true;

      if ($res==true){
        echo '<tr>';
        echo '<td>'.$row['apellidos'] .', '. $row['nombre'] .'</td>';
        echo ' <td>'. $row['identificador'] .'</td>';
        echo ' <td>Consultar</td>';
        echo ' <form method="post" action="destroy.php">';
        echo ' <td><button title="Eliminar" name="becario_seleccionado" value="' . $row['identificador'] . '">Eliminar</button></td>';
        echo '</form>';
        echo '</tr>';
      }
    $db_connection = null;
  }
}

function printAllCSVBecarios(){
  $db_url = 'sqlite:../bd/users.sqlite3';
  $db_connection = new PDO($db_url) or die ("No se ha podido conectar con la BD.");

  $result = $db_connection->query("SELECT apellidos, nombre, identificador FROM becarios");
  foreach($result as $row)
  {
#      echo $row['origen'] . " " . $row['destino'] . " " . "</br>";
      $res = true;

  if ($res==true){
    echo '<tr>';
    echo '<td>'.$row['apellidos'] .', '. $row['nombre'] .'</td>';
    echo ' <td>'. $row['identificador'] .'</td>';
    echo ' <td><button title="Descargar CSV" name="becario_seleccionado" value="' . $row['identificador'] . '">CSV</button></td>';
    echo '</tr>';
  }
  $db_connection = null;
}
}

function CSVUsuario($usuario){
  $db_url = 'sqlite:../bd/users.sqlite3';
  $db_connection = new PDO($db_url) or die ("No se ha podido conectar con la BD.");

  $sentencia = $db_connection->prepare("SELECT id  FROM becarios WHERE identificador = '$usuario'") or die("La sentencia SQL es incorrecta");
  $sentencia->execute();
  $id_usuario = null;
  foreach($sentencia as $row){
    $id_usuario = $row['id'];
  }

  $db_connection = null;
  $sentencia = null;
  return $id_usuario;
}



?>
