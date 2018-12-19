<?php
    session_start();

    require 'vendor/autoload.php';

    $data = $_POST['photo'];
    $timestamp = $_SESSION['timest'];
    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);
    $data = base64_decode($data);

    mkdir($_SERVER['DOCUMENT_ROOT'] . "/photos");

    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/photos/".$timestamp.'.jpg', $data);


    die;
?>
