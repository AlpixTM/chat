<?php
/**
 * Created by PhpStorm.
 * User: a19LukasNie
 * Date: 13.03.2017
 * Time: 15:05
 */
session_start();
include_once 'dbconnect.php';
if ($_SESSION['chat_sessionid']) {
    $userid=$_SESSION['chat_userid'];
    $sesion=$_SESSION['chat_sessionid'];
}
else {
    exit("F1");
}
if (empty($_POST["message"]) OR empty($_POST["roomid"]) OR empty($_POST["typeid"])) {
    if (empty($_POST["message"])){
        echo "mess";
    }
    if (empty($_POST["roomid"]))
    {
        echo "roomid";
    }  if (empty($_POST["typeid"])){
        echo "typeid";
    }
    exit("F2");
}
$message = $_POST['message'];
$roomid= $_POST['roomid'];
$typeid= $_POST['typeid'];
$sql="INSERT INTO `messages` (`id`, `roomid`, `typeid`, `userid`, `txt`, `time`) VALUES (NULL,'$roomid', '$typeid', '$userid', '$message',CURRENT_TIMESTAMP);";
$db_erg=mysqli_query($link,$sql);

if ($db_erg){
    echo"success";
}
else {
    exit("F3");
}
mysqli_free_result ( $db_erg );