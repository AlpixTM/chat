<?php
/**
 * Created by PhpStorm.
 * User: a19LukasNie
 * Date: 27.03.2017
 * Time: 14:58
 */
include 'dbconnect.php';
function get_name($id){
include 'dbconnect.php';
$name = "unbekannt";
    $sql="SELECT `name` FROM `user` WHERE `ID` = $id";
    $db_erg= mysqli_query($link,$sql);
    if (! $db_erg) {
        die ( 'Ungültige Abfrage: ' . mysqli_error () );
    }
    if ($zeile = mysqli_fetch_array ( $db_erg, MYSQL_NUM  )){
        $name= $zeile['0'];
    }
    return $name;
}
$sql="SELECT * FROM `messages`";
$db_erg = mysqli_query ( $link, $sql );
if (! $db_erg) {
    die ( 'Ungültige Abfrage: ' . mysqli_error () );
}
while ($zeile = mysqli_fetch_array ( $db_erg, MYSQL_ASSOC  )) {
    $tempmessage =explode(" ",  $zeile['txt']);
    $runde =0; // Bereits erfolgte Durchgänge = Bearbeitete Worte
    $i = 0; // Wortanzahl die bereits abgearbeitet wurde und in der aktuellen Zeihle stehen wird
$ii=0; // Zerlegung von langen Wörtern in Teilworte auf Basis der durchschnittlich 10 Zeichen pro deutschem Wort
    foreach ($tempmessage as $value){
        $runde ++;
        $i++;
        $ii= ceil(strlen($value)/10);
        if ($ii > 1){
            $ii--;
            $i = $i + $ii;
        }
        if ($ii > 4){
            $tempword= str_split($value, 50);
        //    print_r($tempword) ;
            $wordrunde=0;
            foreach ($tempword as $tempvalue){
                if ($wordrunde == 0){
                    $nextmessage=$tempvalue;
                }
                else{
                    $nextmessage= $nextmessage . "-<br>".  $tempvalue;

                }
                $wordrunde++;
            }
            // echo $nextmessage;
        } else {
            if ($i >= 4) {

                if ($runde != 1) {
                    $i = 0;
                    $nextmessage = $nextmessage . "<br>" . $value;
                } else {
                    $nextmessage = $value . "<br>";
                }
            } else {
                $nextmessage = $nextmessage . " " . $value;
            }
        }
        $ii=0;
    }
    $message=$nextmessage;
    $userid = $zeile['userid'];
    $temptime= explode(" ", $zeile['time']);
    $temptime2= explode(":",$temptime[1]);
    $time =$temptime2[0]. ":". $temptime2[1];
    $name = get_name($userid);

        echo "   <tr>
     <td class=\"mdl-data-table__cell\">$time</td>
        <td>$name</td>
        <td >$message</td>
    </tr>";
    unset($nextmessage);
    unset($message);
    }




mysqli_free_result ( $db_erg );
?>


