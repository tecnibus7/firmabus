<?php
# $color = '';
# $image_filepath = 'photos/1524743558.jpg';
# saveImageWithText("RIVERO CAPELLÁN, J. 2018-04-26 13:54    ", $image_filepath);

function saveImageWithText($text, $source_file) {
  $public_file_path = '.';

  // Create objects
#  $image = new Imagick($source_file);
  $image = new Imagick($source_file);

  // Watermark text
  // El texto se toma de la variable de entrada
#  $text = 'SALIDA de RIVERO CAPELLAN JESUS 25/9/2018 10:00';

  // Create a new drawing palette
  $draw = new ImagickDraw();

  // Set font properties
  $draw->setFont('arial.ttf');
  $draw->setFontSize(10);
  $draw->setFillColor('red');

  // Position text at the bottom-right of the image
  $draw->setGravity(Imagick::GRAVITY_SOUTHEAST);

  // Draw text on the image
  $image->annotateImage($draw, 10, 12, 0, $text);

  // Draw text again slightly offset with a different color
  $draw->setFillColor('yellow');
  $image->annotateImage($draw, 11, 11, 0, $text);

  // Set output image format
  $image->setImageFormat('jpg');
#  $photo = imagecreatefromjpeg($image);


  // Save the picture
  // Guardar la imagen como 'textosimple.jpg'
#  imagejpeg($image, 'output.jpg');;
  $image->writeImage ("output.jpg");

  // Clear
  #imagedestroy($image);
#  imagedestroy($image);
};

function saveRegistroDB($fecha, $accion, $usuario, $verificacion) {
  $solo_fecha = date('d/m/Y', $fecha) ;
  $solo_hora = date('H:i:s', $fecha);
  $db_url = 'sqlite:../bd/users.sqlite3';
  $db_connection = new PDO($db_url) or die ("No se ha podido conectar con la BD.");

  echo " ". $accion . " " . $solo_fecha . " " . $solo_hora . " " . $usuario . " " . $verificacion . "\n ";
  $sentencia = $db_connection->prepare("INSERT INTO registro(operacion, fecha, hora, becario, verificacion) VALUES ('$accion', '$solo_fecha', '$solo_hora', '$usuario', '$verificacion')") or die("La sentencia SQL es incorrecta (sello_imagen)");
  $sentencia->execute();

  $db_connection=null;
  $sentencia=null;

};
