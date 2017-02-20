<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 15.01.17
 * Time: 13:35
 */
session_start();
function encrypt ($pw) {
    $hash = hash('sha256', $pw);
    $pw_en=$hash;
    return $pw_en;
}
include_once 'dbconnect.php';
$salt = uniqid().uniqid().uniqid().uniqid().uniqid();
$name=$_POST['Name'];
$mail=$_POST['mail'];
$pw1=$_POST['pw'];
$pw=$_POST['pw'].$salt;
$pw=encrypt($pw);
if ($name != "" && $mail != "" && $pw1 != "") {
    $sql = "INSERT INTO `user` (`ID`, `Name`, `pw`, `mail`, `salt`, `status`) VALUES (NULL, '$name', '$pw', '$mail', '$salt', '0');";
    $db_erg = mysqli_query($link, $sql);
}
if (! $db_erg) {
    header("Location: /?error=1");
  //  die ( 'Ungültige Abfrage: ' . mysqli_error () );
}
else {
    header("Location: /");
}
?>
?>