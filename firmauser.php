<?php

  $lifetime = strtotime('+2 minutes', 0);
  session_set_cookie_params($lifetime);

  include 'ntp.php';

  $time = date('d/m/Y, H:i:s', $timestamp);
  session_start();
  if(!$_SESSION['user_rol']=="usuario"){
    header("location: index.php");
  }
  $user_id = $_SESSION['user_id'];
  $_SESSION['time_sign'] = $time;
  $_SESSION['timest'] = $timestamp;

  $db_url = 'sqlite:bd/users.sqlite3';
  $db_connection = new PDO($db_url) or die ("No se ha podido conectar con la BD.");
  $result = $db_connection->query("SELECT apellidos, nombre FROM becarios WHERE id = '$user_id' ") or die("Error en la consulta");
  foreach($result as $row){
    $nombre_usuario = $row['nombre'];
    $apellidos_usuario = $row['apellidos'];
  }
  $db_connection = null;

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>firm@BUS</title>
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	  <link rel="stylesheet" href="firmabus-base.css" type="text/css" media="all">

  </head>
  <body>
  <div class="header">
    <h1>firm@BUS</h1>
  </div>
  <div class="camara">
    <video title="VideoCAM" id="video" autoplay>El video no se encuentra disponible en éste momento. Póngase en contacto con el SIT de la Biblioteca.</video>
    <button accesskey="f" title="Hacer foto (f)" id="tomarfoto">Hacer foto</button>
  </div>


  <div class="salidafoto cajas-borde">
    <canvas title="Fotografía capturada" id="foto" width=340 height=240></canvas>
     </div>

  <div class="info-usuario cajas-borde">
        <div class="header"> Datos del Usuario</div>
        <div>
          <p>Hora del sistema:</p>
          <p><?php echo $time; ?></p>
          <p>Usuario:</p>
          <p><?php echo $apellidos_usuario . ", " . $nombre_usuario; ?></p>
        </div>
  </div>

  <div class="menu-firma">
    <div class="header">Opciones de firma</div>
    <div>
      <form method="post" action = "mailing/notify.php">
        <button accesskey="e" title="Registrar entrada (e)" class="entrar-img" name="operacion" value="entrar" id="entrar">Entrar</button>
        <button accesskey="s" title="Registrar salida (s)" class="salir-img" id="salir" name="operacion" value="salir">Salir</button>
      </form>
    </div>
  </div>

  <div class="footer">
    <?php include "footer.php"; ?>
  </div>

<!---   <video id="player" autoplay></video>  --->
<!--  <button id="capture">Capturar</button> --->
<!--  <canvas id="snapshot" width=320 height=240></canvas>  --->


  <script>
    var player = document.getElementById('video');
    var snapshotCanvas = document.getElementById('foto');
    var captureButton = document.getElementById('tomarfoto');

    var handleSuccess = function(stream) {
      // Attach the video stream to the video element and autoplay.
      player.srcObject = stream;
    };

    captureButton.addEventListener('click', function() {
      var context = foto.getContext('2d');
      // Draw the video frame to the canvas.
      context.drawImage(player, 0, 0, snapshotCanvas.width,
          snapshotCanvas.height);

      // Enviar el canvas a PHP
      var photo = foto.toDataURL('image/jpeg');
      $.ajax({
        method: 'POST',
        url: 'savephoto.php',
        data: {
          photo: photo
        }
      });

      // Fin reenvío
    });

    navigator.mediaDevices.getUserMedia({video: true})
        .then(handleSuccess);




  </script>




  </body>
</html>
