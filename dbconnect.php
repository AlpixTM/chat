<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 15.01.17
 * Time: 13:14
 */
// Nachfolgend wird eine Verbindung zum DB-Server aufgebaut. In anderen Files eingebunden ist diese Verbidnung unter "§link" abrufbar.
$dev = true;
include_once "dbconf.php"; // Die in mysqli_connect genutzten Werte wurden in der "dbconf.php" definiert
$link = mysqli_connect(MYSQL_HOST, MYSQL_BENUTZER, MYSQL_KENNWORT, MYSQL_DATENBANK, MYSQL_PORT);
if (!$link) {
    if ($dev == "true") {
        die('Connect Error: ' . mysqli_connect_error());
    } else {
        die('Connect Error! (Enable Dev for more informations.)');
    }
}
mysqli_set_charset($link, 'utf8');
?>
