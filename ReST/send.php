<?php
/**
 * Created by PhpStorm.
 * User: a19LukasNie
 * Date: 13.03.2017
 * Time: 15:05
 */

//Nachfolgend wird eine Nachricht in der DB gespeichtert

session_start();
include_once 'dbconnect.php';
include_once(dirname(__FILE__) . "/../config.php");
include_once (dirname(__FILE__) . "/../chatFunctions.php");
$ip = $_SERVER['REMOTE_ADDR'];
if ($_SESSION['chat_sessionid']) {                  // Wenn der Nutzer auch wirklich angemeldet ist, dann ...
    $userid = $_SESSION['chat_userid'];               // ... wird seine User-ID gespeichert
} else {
    exit("F1");                                     // Wenn der Nutzer keine Session hat => nicht angemeldet ist, dann bricht das Script mit dem Status "F1" ab
}
isLoggedIn();
if (empty($_POST["message"]) OR empty($_POST["roomid"]) OR empty($_POST["typeid"])) {   // Prüft ob alle benötigten Daten vorhanden sind
    if (empty($_POST["message"])) {
        echo "message fehlt";
    }
    if (empty($_POST["roomid"])) {
        echo "roomid fehlt";
    }
    if (empty($_POST["typeid"])) {
        echo "typeid fehlt";
    }
    exit("F2");                                     // Wenn Daten fehlen bricht das Script mit dem Status "F2" ab, vorher werden die fehlenden Daten ausgegeben => später im log gespeichtert
    // (siehe main.php - js Funktion send)
}
$message = mysqli_real_escape_string($link, $_POST['message']);
$roomid = mysqli_real_escape_string($link, $_POST['roomid']);
$typeid = mysqli_real_escape_string($link, $_POST['typeid']);
if ($ip_log == true) {
    $sql = "INSERT INTO `messages` (`id`, `roomid`, `typeid`, `userid`, `txt`, `time`, `ip` ) VALUES (NULL,'$roomid', '$typeid', '$userid', '$message',CURRENT_TIMESTAMP,'$ip');"; // Nachricht wird in DB gespeichert
} else {
    $sql = "INSERT INTO `messages` (`id`, `roomid`, `typeid`, `userid`, `txt`, `time`, `ip` ) VALUES (NULL,'$roomid', '$typeid', '$userid', '$message',CURRENT_TIMESTAMP,'ip logging off');"; // Nachricht wird in DB gespeichert
}
$db_erg = mysqli_query($link, $sql);

if ($db_erg) {
    echo "success";                                  // Bei Erfolg wird success ausgegeben
} else {
    exit("F3");                                     // Bei Misserfolg wird das Script mit dem Status "F3" abgebrochen
}
mysqli_free_result($db_erg);