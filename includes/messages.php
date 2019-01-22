<?php
/**
 * Created by PhpStorm.
 * User: a19LukasNie
 * Date: 27.03.2017
 * Time: 14:58
 */
include 'dbconnect.php';
include_once(dirname(__FILE__) . "/../Escaper/Escaper.php");  // Escaper class um xss zu verhindern
$escaper = new Zend\Escaper\Escaper('utf-8');

function get_name($id) {
    global $link;
    $name = "unbekannt"; //Fallback falls der Name nicht über die ID gefunden wird. (Warum auch immer)
    $sql = "SELECT `name` FROM `user` WHERE `ID` = $id";
    $db_erg = mysqli_query($link, $sql);
    if (!$db_erg) {
        die ('Ungültige Abfrage: ' . mysqli_error($link));
    }
    if ($zeile = mysqli_fetch_array($db_erg, MYSQLI_NUM)) {
        $name = $zeile['0']; // Nimmt ersten Eintrag. Wenn mehrere Accounts mit der ID verbunden sind, wird also nur der Erste genommen.
    }
    return $name;
}

$max_messages = mysqli_real_escape_string($link, $_GET['max_messages']);
if (!$max_messages OR $max_messages == 0) {
    $sql = "SELECT * FROM  (SELECT * FROM `messages` ORDER BY `ID` DESC LIMIT 0, 12) TEMP1 ORDER BY `ID`  ASC"; // Holt sich die letzten 12 Nachrichten
}
if ($max_messages) {
    $sql = "SELECT * FROM  (SELECT * FROM `messages` ORDER BY `ID` DESC LIMIT 0, $max_messages) TEMP1 ORDER BY `ID`  ASC";
}

$db_erg = mysqli_query($link, $sql);
if (!$db_erg) {
    die ('Ungültige Abfrage: ' . mysqli_error($link));
}
while ($zeile = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
    // Nachfolgend werden Zeilenumbrüche eingefügt um die Länge der einzelnen Zeilen im Chat zu regulieren
    $tempmessage = explode(" ", $escaper->escapeHtml($zeile['txt'])); // Nachricht wird in einzelne Worte zersetzt. Trennungsmerkmal eines Wortes ist ein Leerzeichen.
    $runde = 0;                                                                // Bereits erfolgte Durchgänge = Verarbeitete Worte
    $i = 0;                                                                     // Wortanzahl die bereits abgearbeitet wurde und der aktuellen Zeile zugeordnet wurde
    $ii = 0;                                                                    /* Anzahl von Teilen eines zerlegten Wortes -
                                                                                   Zerlegung von langen Wörtern in Teilworte auf Basis der durchschnittlich 10 Zeichen pro deutschem Wort
                                                                                   -> So werden lange Zeichenketten getrennt
                                                                                 */
    foreach ($tempmessage as $value) {
        $runde++;                                      // +1 Durchgang
        $i++;                                           // +1 Wort in der aktuellen Zeile. Wird nach Zeilenumbruch auf 0 gesetzt
        $ii = ceil(strlen($value) / 10);             // Anzahl der Wortteile die aus dem Wort entsethen. Als Wort zählen jeweils 10 Zeichen, wenn das Wort länger als 10 ist
        if ($ii > 1) {                                   // Wenn Zeichenkette als mehr als nur ein Wort zählt (Ab 20 Zeichen -> $ii = Zeichenkettenlänge/10 > 1)
            $ii--;                                      // -1 Wort wenn das Wort z.b. als 3 zählt ( zwischen 30 -40 Zeichen), weil jede Zeichenkette schon in §i als ein Wort in der Zeile zählt
            $i = $i + $ii;                              // $i (Anzahl der bisherigen Worte in der Zeile) + $ii (Als wieviel Wörter ein langes Wort zählt)
        }
        if ($ii > 4) {                                   // Wenn das Wort länger als 50 Zeichen ist >50/10=>4 muss es nach 50 Zeichen gebrochen werden,da nur 50 Wörter->max 50 Zeichen pro Zeile
            $tempword = str_split($value, 50); // Zeichenkette wird an allen 50 Zeichen gebrochen
            $wordrunde = 0;                               // Über wieviele Durchgänge = Zeilen das Wort schon gebrochen wird
            foreach ($tempword as $tempvalue) {          // Jeder Wortteil wird nachfolgend mit -<br> geteilt und in der Zeile platziert
                if ($wordrunde == 0) {
                    $nextmessage = $tempvalue;
                } else {
                    $nextmessage = $nextmessage . "-<br>" . $tempvalue;

                }
                $wordrunde++;
            }
        } else {                                        // Wenn das Wort nicht länger als 10 Zeichen ist und somit als ein Wort zählt
            if ($i >= 4) {                              // Wenn sich in der Zeile schon mehr als 5 Wörter befinden
                if ($runde != 1) {                      // Wenn es sich nicht um den erste Durchgang = Zeile handelt
                    $nextmessage = $nextmessage . "<br>" . $value; // Wort wird mit Zeilenumbruch angehängt
                    $i = 0;                             // Anzahl der Wörter in der aktuellen Zeile werden auf 0 gesetzt
                } else {                                // Wenn es sich um den ersten Durchgang = Zeile handelt
                    $nextmessage = $value . "<br>";     // Zeilenumbruch wird nach dem Wert angehängt
                }
            } else {                                    // Wenn sich in der Zeile noch nicht mehr als 4 Wörter befinden
                $nextmessage = $nextmessage . " " . $value;// Wort wird der aktuellen Zeile angehängt
            }
        }
        $ii = 0;
    }
    $message = $nextmessage;                              // Message wird mit den eingefügten Zeilenumbrüchen eingefügt
    $userid = $zeile['userid'];
    $temptime = explode(" ", $zeile['time']);
    $temptime2 = explode(":", $temptime[1]);
    $time = $temptime[0] . " " . $temptime2[0] . ":" . $temptime2[1];
    $name = $escaper->escapeHtml(get_name($userid));
    // Nachfolgend wird die Nachricht ausgegeben
    echo "   <tr>
     <td class=\"mdl-data-table__cell\">$time</td>
        <td>$name</td>
        <td >$message</td>
    </tr>";
    unset($nextmessage);
    unset($message);
}


mysqli_free_result($db_erg);
?>


