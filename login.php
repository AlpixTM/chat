<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 15.01.17
 * Time: 12:39
 */

// Hier wird der Nutzer mit den Daten aus dem Login-Formular angemeldet

session_start();
include_once 'dbconnect.php';
include_once 'config.php';
function encrypt($pw)
{                                                                // Das PW wird mit dem algo "sha256" codiert
    $hash = hash('sha256', $pw);
    $pw_en = $hash;
    return $pw_en;                                                                      // Gibt das codierte PW zurück
}

function update_ip($name) {                                                         // Sobald der Nutzer eingeloggt wurde wird der status auf 1 => online gestellt.
    global $link;
    global $ip_log;
    if ($ip_log == true) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $sql = "UPDATE `user` SET `ip` = '$ip' WHERE `Name`='$name'";
        mysqli_query($link, $sql);
    }
}

function update_status($name) {                                                         // Sobald der Nutzer eingeloggt wurde wird der status auf 1 => online gestellt.
    global $link;
    $sql = "UPDATE `user` SET `status` = '1' WHERE `Name`='$name'";
    mysqli_query($link, $sql);
}

$name = mysqli_real_escape_string($link, $_POST['Name']);
$sql = "SELECT `salt` FROM `user` WHERE `Name` = '$name'";                                // Der Salt, ein Wert, der an das PW gehängt wird um es vor decodierung zu schützen,
$db_erg = mysqli_query($link, $sql);                                                 // wird über den Nutzernamen geholt
if (!$db_erg) {
    die ('Ungültige Abfrage: ' . mysqli_error($link));
}
while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
    $salt = $zeile['salt'];
}
mysqli_free_result($db_erg);
$pw = mysqli_real_escape_string($link, $_POST['pw'] . $salt);                       // Salt wird an das "echt" PW angehängt
$pw = encrypt($pw);                                                                       // Das PW wird codiert
$sql = "SELECT `status`,`id` FROM `user` WHERE `Name` = '$name' AND `pw` = '$pw'";
$db_erg = mysqli_query($link, $sql);
while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_NUM)) {
    $userid = $zeile["1"];
    if ($zeile["0"] == 0 or 1 == $zeile["0"]) {
        $su = true;
        $_SESSION['chat_sessionid'] = "$name";                                            // Login war erfolgreich, name und id werden in die Session gespeichert
        $_SESSION['chat_userid'] = "$userid";
        update_status($name);                                                           // Die Funktion, die den Online-Status updatet wird aufgerufen
        update_ip($name);
        header("Location: main.php");                                             // Eingelogter Nutzer wird auf die "Hauptseite" weitergeleitet
    }
}

if (!$db_erg OR $su == false) {                                                           // Ist das Login fehlgeschlagen, dann wird der nutzer wieder auf die Wurzel weitergeleitet
    header("Location: /#LoginFailed");
}