<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 15.01.17
 * Time: 13:35
 */
// Nachfolgend wird ein neuer Nutzer angelegt
session_start();
function encrypt ($pw) {                                                    // Das PW wird mit dem algo "sha256" codiert
    $hash = hash('sha256', $pw);
    $pw_en=$hash;
    return $pw_en;                                                          // Gibt das codierte PW zurück
}

include_once 'dbconnect.php';                                               // DB-Verbindung wird aufgebaut, abrufbar unter "$link"
$salt = uniqid().uniqid().uniqid().uniqid().uniqid();                       // Salt wird generiert
$name=mysqli_real_escape_string($link,$_POST['Name']);
$mail=mysqli_real_escape_string($link,$_POST['mail']);
$pw1=mysqli_real_escape_string($link,$_POST['pw']);
$pw=mysqli_real_escape_string($link,$_POST['pw'].$salt);           // Salt wird an das "echt" PW angehängt
$pw=encrypt($pw);                                                           // Das PW wird codiert
if ($name != "" && $mail != "" && $pw1 != "") {                             // Wenn alle benötigten Daten gegebn sind, wird der neue Nutzer angelegt
    $sql = "INSERT INTO `user` (`ID`, `Name`, `pw`, `mail`, `salt`, `status`) VALUES (NULL, '$name', '$pw', '$mail', '$salt', '0');";
    $db_erg = mysqli_query($link, $sql);
}
if (! $db_erg) {                                                             // Schlägt das Anlegen des neuen Nutzers fehl, wird er auf die Wurzel geleitet
    header("Location: /?error=1");
  //  die ( 'Ungültige Abfrage: ' . mysqli_error () );
}
else {                                                                        // Wurde der Nutzer erfolgreich angelegt, wird er auf die Wurzel geleitet
    header("Location: /");
}
?>
