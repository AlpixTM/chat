<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 15.01.17
 * Time: 13:35
 */
// Registrierung eines neuen Nutzers
session_start();

include_once 'dbconnect.php';                                               // DB-Verbindung wird aufgebaut, abrufbar unter "$link"


function encrypt($pw) {                                                     // Das PW wird mit dem algo "sha256" codiert
    $hash = hash('sha256', $pw);
    $pw_en = $hash;
    return $pw_en;                                                          // Gibt das codierte PW zurück
}

$salt = uniqid() . uniqid() . uniqid() . uniqid() . uniqid();               // Salt wird generiert
$name = mysqli_real_escape_string($link, $_POST['NameREG']);
$mail = mysqli_real_escape_string($link, $_POST['mailREG']);
$pw1  = mysqli_real_escape_string($link, $_POST['pwREG']);
$pw   = mysqli_real_escape_string($link, $_POST['pwREG'] . $salt); // Salt wird an das "echt" PW angehängt
$pw   = encrypt($pw);                                                       // Das PW wird codiert


$doubleName = true;

$sql = "SELECT COUNT(ID) FROM `user` WHERE `Name` LIKE '$name'";
$db_erg = mysqli_query($link, $sql);
if (!$db_erg) {
    die ('Ungültige Abfrage: ' . mysqli_error($link));
}
while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_NUM)) {
    $count = $zeile['0'];

    if( $count == 0) {
        $doubleName = false;
    }
}

if ($name != "" && $mail != "" && $pw1 != "" && !$doubleName) {                             // Wenn alle benötigten Daten gegebn sind, wird der neue Nutzer angelegt
    $sql = "INSERT INTO `user` (`ID`, `Name`, `pw`, `mail`, `salt`, `status`) VALUES (NULL, '$name', '$pw', '$mail', '$salt', '0');";
    $db_erg = mysqli_query($link, $sql);
}

if (!$db_erg || $doubleName) {                                                             // Schlägt das Anlegen des neuen Nutzers fehl, wird er auf den Index geleitet
    header("Location: /?error=1");
    // die ( 'Ungültige Abfrage: ' . mysqli_error () );
} else {                                                                    // Wurde der Nutzer erfolgreich angelegt, wird er auf die Wurzel geleitet
    header("Location: /");
}

exit(0);
?>
