<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 20.01.17
 * Time: 16:56
 */
// Nachfolgend werden die durch das Kontakt-Formular gesendeten Werte in eine E-Mail gepackt und an diese gesendet.
$empfaenger = "contact@alpix.eu";
$z="\n";
$ip=$_SERVER['REMOTE_ADDR'];
$text="Hallo,\n";
$text=$text.$z."IP:".$ip;
                   foreach ($_POST as $key => $value) {
                       $text=$text.$z.$key." : ".$value;
                   }
echo $text;
$betreff = "Neuer Eintrag im Formular der Chatsite";
$from = "Von: Formular-Robot <sendmail@alpix.eu>";
mail($empfaenger, $betreff, $text, $from);
header('Location: /');
?>
