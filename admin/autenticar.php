<?php
#  $lifetime = strtotime('+10 minutes', 0);
#  session_set_cookie_params($lifetime);


#  require '../lib/phpass-master/src/Phpass.php';
  $user_admin = $_POST['f_identificador'];
  $password = $_POST['f_passwd'];
#  use Phpass\Hash;

#  $crypt = new Hash;
#  $hash = $crypt->hashPassword($password);
#  if ($crypt->checkPassword($password, $hash)) {
#    echo "Pass:" . $password . "Crypt: " . $hash . "\n <br>";
#  }

if ($user_admin == 'tecnibusADM' && $password == 'TeMpOrAl18')
{
  session_start();
  $_SESSION['user_rol'] = "administrador";
  header("location: firmaadmin.php");
} else {
  header("location: index.php");
}
?>
