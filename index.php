<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>firm@BUS</title>
	  <link rel="stylesheet" href="firmabus-base.css" type="text/css" media="all">

  </head>
  <body>
  <div class="header">
    <h1>firm@BUS</h1>
  </div>

  <div class="inicio-procedimiento cajas-borde">
    <div class="header header-estrecho">
      <h1>Identificación</h1>
    </div>
    <?php echo $_REQUEST['ERR_MSG'] ?>
    <form method="post" action = "autenticar.php">
      <p><label for="f_identificador">identificador:</label></br>
      <input type="text" accesskey="u" name="f_identificador" id="f_identificador"></input></p>
      <p><button accesskey="i" id="identificar">Iniciar procedimiento</button></p>
    </form>
  </div>



  <div class="footer">
    <?php include "footer.php"; ?>
  </div>


  </body>
</html>
