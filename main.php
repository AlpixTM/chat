<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 15.01.17
 * Time: 12:49
 */
session_start();

if ($_SESSION['chat_sessionid']) {
   echo "logged in ";
  $sesion=$_SESSION['chat_sessionid'];
}
else {
    print_r($_SESSION);
    //header("Location: http://acp.alpixmc.de/login.php");
    die("Bitte neu einloggen");
}
