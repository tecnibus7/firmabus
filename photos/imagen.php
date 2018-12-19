<?php

// Create objects
$image = new Imagick('1524743558.jpg');

// Watermark text
$text = 'SALIDA de RIVERO CAPELLAN JESUS 25/9/2018 10:00';

// Create a new drawing palette
$draw = new ImagickDraw();

// Set font properties
$draw->setFont('Arial');
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

// Output the new image
#header('Content-type: image/jpg');
#echo $image;
#$image->setImageFormat ("jpeg");
$image->writeImage ("test_0.jpg");
