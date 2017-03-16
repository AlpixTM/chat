<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 15.01.17
 * Time: 13:14
 */
$dev=true;
include_once "dbconf.php";
$link = mysqli_connect ( MYSQL_HOST, MYSQL_BENUTZER, MYSQL_KENNWORT, MYSQL_DATENBANK, MYSQL_PORT );
if (!$link) {
    if ($dev=="true") {
        die('Connect Error: ' . mysqli_connect_error());
    }
    else{
        die('Connect Error! (Enable Dev for more informations.)');
    }
}
mysqli_set_charset ( $link, 'utf8' );
?>
