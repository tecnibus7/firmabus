<?php
  $lifetime = strtotime('+2 minutes', 0);
  session_set_cookie_params($lifetime);


   $db_url = 'sqlite:bd/users.sqlite3';
   $db_connection = new PDO($db_url) or die ("No se ha podido conectar con la BD.");
   $identificador_form = $_POST['f_identificador'];

   $result = $db_connection->query("SELECT id FROM becarios WHERE identificador = '$identificador_form' ");
   foreach($result as $row)
   {
#      echo $row['origen'] . " " . $row['destino'] . " " . "</br>";
       $res = true;
   };
   if ($res==true){
     session_start();
     $_SESSION['user_id'] = $row['id'];
     $_SESSION['user_rol'] = "usuario";
     header("location: firmauser.php");
   }else{
     session_destroy();
      header("location: index.php");
   }
   $db_connection = null;
?>
