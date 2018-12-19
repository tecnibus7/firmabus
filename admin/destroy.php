<?php
  session_start();
  if(!$_SESSION['user_rol']=="administrador"){
    header("location: index.php");
  }

  include "data.php";
#  destroyUser();
  $usuario = $_POST['becario_seleccionado'];

  destroyUser($usuario);
  header("location: actualizar.php");
?>
