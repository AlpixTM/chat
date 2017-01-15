<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 15.01.17
 * Time: 12:39
 */
session_start();
include_once 'dbconnect.php';
function encrypt ($pw) {
    $hash = hash('sha256', $pw);
    $pw_en=$hash;
    return $pw_en;
}
$name=$_POST['Name'];
$sql="SELECT `salt` FROM `user` WHERE `Name` = '$name'";
$db_erg = mysqli_query ( $link, $sql );
if (! $db_erg) {
        die ( 'Ungültige Abfrage: ' . mysqli_error () );
    }
while ($zeile = mysqli_fetch_array ( $db_erg, MYSQL_ASSOC  )) {
    $salt=$zeile['salt'];
}
mysqli_free_result ( $db_erg );
$pw=$_POST['pw'].$salt;
$pw=encrypt($pw);
$sql="SELECT `status` FROM `user` WHERE `Name` = '$name' AND `pw` = '$pw'";
$db_erg = mysqli_query ( $link, $sql );
if (! $db_erg) {
    header("Location: /chat/");
}
else{
    $_SESSION['chat_sessionid']="$name";
    header("Location: main.php");
}


