<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 20.01.17
 * Time: 16:56
 */
$empfaenger = "contact@alpix.eu";
$z="\n";
$ip=$_SERVER['REMOTE_ADDR'];
$text="Hallo,\n";
$text=$text.$z."IP:".$ip;
                   foreach ($_POST as $key => $value) {
                       $text=$text.$z.$key." : ".$value;
                   }
echo $text;
$betreff = "Neuer Eintrag im Formular";
$from = "Von: Formular-Robot <Robot@not-existend.de>";
mail($empfaenger, $betreff, $text, $from);
header('Location: /');
?>