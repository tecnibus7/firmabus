<?php

function getNTPDate($host) {

  $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP) or die("No se puede acceder al servidor de hora.");
#  $sconn = socket_connect($sock, $host, 123);


  if (!$sconn)
    return date(U);
    #die("Error de conexión con servidor remoto ntp.");
  else{
    $msg = "\010" . str_repeat("\0", 47);
    socket_send($sock, $msg, strlen($msg), 0);


    socket_recv($sock, $recv, 48, MSG_WAITALL) or die("No ha habido respuesta del servidor ntp");
    socket_close($sock);


    $data = unpack('N12', $recv);
    $timestamp = sprintf('%u', $data[9]);

    $timestamp -= 2208988800;

    return $timestamp;
  }
}

/* Configuración de socket */
try{
  $host = 'hora.roa.es';
  $timestamp = getNTPDate($host);
}catch (Exception $e){
  echo "No es posible obtener la hora.";
}
#$time = date('d/m/Y, H:i:s', $timestamp);
#echo $time;


?>
