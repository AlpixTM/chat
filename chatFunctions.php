<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 24.12.17
 * Time: 13:03
 */

include_once 'dbconnect.php';
date_default_timezone_set('Europe/Berlin');


function isLoggedIn() {
    $url = parse_url($_SERVER['REQUEST_URI']);
    $url = $url['path'];
    if ($_SESSION['chat_sessionid']) {                          // Prüft ob Session besteht => ob der Nutzer angemeldet ist. Wenn ja, dann update session, damit timestamp geupdatet wird
        global $link;
        $name = $_SESSION['chat_sessionid'];
        $time = date("Y-m-d H:i:s",strtotime("NOW"));
        $sql = "UPDATE `user` SET `status_update` = '$time' WHERE `Name`='$name'";
        mysqli_query($link, $sql);
        if ($url == '/' or $url == "/index.php") {
            header("Location: /main.php");
            exit(0);
        }
    }
    else {
        if ($url != '/' and $url != "/index.php") {
            header("Location: /");
            die("Bitte neu einloggen");
        }
    }
}
?>