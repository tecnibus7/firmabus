<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Administración | firm@BUS</title>
	  <link rel="stylesheet" href="../firmabus-base.css" type="text/css" media="all">

  </head>
  <body>
  <div class="header">
    <h1>Administración | firm@BUS</h1>
  </div>

  <div class="inicio-procedimiento cajas-borde">
    <div class="header header-estrecho">
      <h1>Identificación</h1>
    </div>
    <div>
    <form method="post" action = "./autenticar.php" >
      <p><label for="f_identificador">Identificador:</label></br>
      <input type="text" name="f_identificador" id="f_identificador" accesskey="u"></input></p>
      <p><label for="f_passwd">Contraseña::</label></br>
      <input type="password" name="f_passwd" id="f_passwd" accesskey="p"></input></p>
      <p><button id="identificar" accesskey="i">Iniciar procedimiento</button></p>
    </div>
    </form>
  </div>



  <div class="footer">
    <?php include "../footer.php"; ?>
  </div>


  </body>
</html>
