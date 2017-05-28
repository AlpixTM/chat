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
$name=mysqli_real_escape_string($link,$_POST['Name']);
$mail=mysqli_real_escape_string($link,$_POST['mail']);
$pw1=mysqli_real_escape_string($link,$_POST['pw']);
$pw=mysqli_real_escape_string($link,$_POST['pw'].$salt);
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