<?php
##############################
# Script de notificación de formas
# requiere configuración de variables de entorno
# del sistema
# consulte el manual de su SO para ello.
# En Ubuntu export env VARIABLE="valor"
# Ha de configurarse la eleccion de PHPMAILER
# en su versión 5.2 o 6.0 y el uso de composer
##############################


// DESCOMENTAR PARA USAR PHPMAILER 5.2.X
#require '../vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
// DESCOMENTAR PARA USAR PHPMAILER 6.X
#use PHPMailer\PHPMailer\PHPMailer as PHPMailer;
#use PHPMailer\PHPMailer\Exception as PHPMailer;
//PARA USAR SIN composer
require '../lib/PHPMailer/PHPMailerAutoload.php';


// DESCOMENTAR PARA USAR CON COMPOSER
#require '../vendor/autoload.php';

require '../sello_imagen.php';

session_start();
$user_id = $_SESSION['user_id'];
$time_sign = $_SESSION['time_sign'];

$accion = null;
if ($_POST['operacion']=="entrar"){
  $accion = "entrada";
}else if ($_POST['operacion']=="salir"){
  $accion = "salida";
}

$db_url = 'sqlite:../bd/users.sqlite3';
$db_connection = new PDO($db_url) or die ("No se ha podido conectar con la BD.");
$result = $db_connection->query("SELECT apellidos, nombre, email_user, email_control FROM becarios WHERE id = '$user_id' ") or die("Error en la consulta");
foreach($result as $row){
  $nombre_usuario = $row['nombre'];
  $apellidos_usuario = $row['apellidos'];
  $email_usuario = $row['email_user'];
  $email_control = $row['email_control'];
}
$db_connection = null;



$image_filepath = '../photos/'. $_SESSION['timest'] .'.jpg';
echo $image_filepath;
if (!file_exists($image_filepath)) {
  header("location: ../error.php");
}

saveImageWithText($apellidos_usuario . ", " . $nombre_usuario . " | " . $time_sign . " ". $accion . "    ", $image_filepath);


$photo_code = md5_file('output.jpg');


$fecha = $_SESSION['timest'];
saveRegistroDB($fecha, $accion, $user_id, $photo_code);

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 0;
    $mail->CharSet = "UTF-8";
    $mail->setLanguage('es', '/vendor/phpmailer/phpmailer/language/');                               // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'mail.us.es';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = getenv('FIRMABUS_USERMAIL');                 // SMTP username
    $mail->Password = getenv('FIRMABUS_PASSWDMAIL');                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom(getenv('FIRMABUS_FROMMAIL'), 'firm@BUS');
    $mail->addAddress($email_control, 'Gestor firm@BUS' );     // Add a recipient
    $mail->addReplyTo($email_control, 'firm@BUS');
    $mail->addCC($email_usuario, $nombre_usuario ." " . $apellidos_usuario );

    //Attachments
    $mail->addAttachment('output.jpg');    // Optional name

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = '[firm@BUS DEV] Comprobante de operación de ' . $accion;
    $mail->Body    = '  <div style="padding: 2%; margin: 5%; margin-bottom: 0%; aling-items: center; justify-content: center; background-color: #F7F8E0; color: #3104B4; font-family: Verdana, Arial, Helvetica, sans-serif; ">' .
                     '    <div>' .
                     '      <h1>firm@BUS</h1>' .
                     '      <h2 style="margin-left: 3%">Comprobante de ' . $accion . '</h2>' .
                     '    </div>' .
                     '    <div style="margin-top:5%; padding-right: 3% ;padding-left: 3%; padding-top: 0.5%; margin-bottom: 3%; background-color: white; color: black;">' .
                     '      <p>A continuación se indican los datos y detalles relativos a la operación de control de acceso realiada por usted en el sistema. En caso de incoherencía o error, dirijase a su gestor. Adjunto se remite fotografía sellada temporalmente o XML del resguardo para validación posterior.</p>' .
                     '      <p><spam style="padding: 1%; font-weight: bold">Apellidos y nombre:</spam> <spam style="font-size: 160%;">' . $apellidos_usuario . ', ' . $nombre_usuario . '</spam>' .
                     '      <br><spam style="padding: 1%; font-weight: bold">Operación:</spam> <spam style="font-size: 160%;">' . $accion . '</spam>' .
                     '      <br><spam style="padding: 1%; font-weight: bold">Fecha y hora:</spam> <spam style="font-size: 160%;">' . $_SESSION['time_sign'] . '</spam>' .
                     '      <br><spam style="padding: 1%; font-weight: bold">Código de operación:</spam> <spam style="font-size: 160%;">'. $photo_code .'</spam></p>' .
                     '    <p style="text-align: right; font-size: 60%;">' . $_SESSION['timest'] . '</p>' .
                     '    </div>' .
                     '  </div>' .
                     '  <div style="padding-top: 1%; padding-bottom: 3%;margin: 5%; margin-top: 1% ;aling-items: center; justify-content: center; background-color: #424242; color: #FFFF00; font-family: Verdana, Arial, Helvetica, sans-serif; ">' .
                     '    <p style="text-align: center">firm@BUS v2.0 - Servicio de Informática y Tecnología <br>' .
                     '       Biblioteca de la Universidad de Sevilla - Universidad de Sevilla<br>' .
                     '       Mensaje envíado automáticamente.</p>' .
                     '  </div>';

    $mail->AltBody = "#########################################\n" .
                     "                firm@BUS                 \n\n" .
                     "#########################################\n" .
                     "Comprobante de " . $accion . "\n\n" .
                     "A continuación se indican los datos y detalles relativos a la operación de control de acceso realiada por usted en el sistema. En caso de incoherencía o error, dirijase a su gestor. Adjunto se remite fotografía sellada temporalmente o XML del resguardo para validación posterior.\n\n" .
                     "* Apellidos y nombre: " . $apellidos_usuario . ", " . $nombre_usuario . "\n" .
                     "* Operación: " . $accion . "\n" .
                     "* Fecha y hora: " . $time_sign . "\n" .
                     "* Código de operación: " . $photo_code .
                     $_SESSION['timest'] . "\n\n" .
                     "firm@BUS v2.0 - Servicio de Informática y Tecnología \n  Biblioteca de la Universidad de Sevilla - Universidad de Sevilla \n  Mensaje envíado automáticamente. ";

    $mail->send();

    header("location: ../index.php");
  } catch (Exception $e) {
#    echo 'No se ha podido enviar el correo. Mailer Error: ', $mail->ErrorInfo;
    $mail = null;
#    $_REQUEST['ERR_MSG'] = "No se pudo enviar el correo.";
    header("location: ../index.php");

}
