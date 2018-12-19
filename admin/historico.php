<?php
$lifetime = strtotime('+5 minutes', 0);
session_set_cookie_params($lifetime);
session_start();
if(!$_SESSION['user_rol']=="administrador"){
  header("location: index.php");
}

  include 'data.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>firm@BUS - Descarga de histórico</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="../firmabus-base.css" type="text/css" media="all">

  </head>
  <body>
  <div class="container-fluid">
    <div class="row">
      <div class="col header">
        <h1>Administración | Descarga de históricos</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-4">
        <div class="info-usuario cajas-borde">
          <div class="header header-estrecho">
            <h2>Opciones</h2>
          </div>
          <div>
            <ul>
              <?php include 'menu.php'; ?>
            </ul>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="info-usuario cajas-borde caja-admin">
          <div class="header header-estrecho">
            <h2>Listado de usuarios</h2>
          </div>
          <div class="form">
            <table style="width:100%">
              <tr>
                <th>Apellidos y nombre</th>
                <th>Identificador</th>
                <th></th>
              </tr>
              <form method="post" action="tocsv.php">
              <?php printAllCSVBecarios(); ?>
              </form>
            </table>
                        <!-- Añadir aquí el listado de usuarios -->
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col footer">
        <?php include "../footer.php"; ?>
      </div>
    </row>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

  </body>
</html>
