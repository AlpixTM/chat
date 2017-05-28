<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 16.03.17
 * Time: 14:21
 */
// Nachfolgend werden alle Nutzer ausgegeben, deren status = 1 => online ist
    $sql="SELECT `ID`,`Name`,`img` FROM `user` WHERE `status` = '1'";
    $db_erg = mysqli_query ( $link, $sql );
    if (! $db_erg) {
        die ( 'Ungültige Abfrage: ' . mysqli_error () );
    }
    while ($zeile = mysqli_fetch_array ( $db_erg, MYSQL_ASSOC  )) {
        $name=$zeile['Name'];
        $id=$zeile['ID'];
        $img=$zeile['img'];
        if ($img==1) {
            echo "
    <li class='mdl-list__item mdl-list__item--two-line'>
        <span class='mdl-list__item-primary-content'>
               <i class=\"material-icons mdl-list__item-avatar\"><img style=\"height: 40px; width: 40px; box-sizing: border-box; border-radius: 50%; background-color: rgb(117, 117, 117); font-size: 40px; color: rgb(255, 255, 255);\" src=\"img/$id.jpg\"></i>
           <span>$name</span>
           <span class='mdl-list__item-sub-title'>online</span>
        </span>
        <span class='mdl-list__item-secondary-content'>
          <a class='mdl-list__item-secondary-action' href='#'><i class='material-icons'>info</i></a>
        </span>
    </li>
";
        }
        else {
            echo "            
    <li class='mdl-list__item mdl-list__item--two-line'>
        <span class='mdl-list__item-primary-content'>
               <i class=\"material-icons mdl-list__item-avatar\"><img style=\"height: 40px; width: 40px; box-sizing: border-box; border-radius: 50 %; background-color: rgb(117, 117, 117); font-size: 40px; color: rgb(255, 255, 255);\" src=\"img/default.jpg\"></i>
           <span>$name</span>
           <span class='mdl-list__item-sub-title'>online</span>
        </span>
        <span class='mdl-list__item-secondary-content'>
          <a class='mdl-list__item-secondary-action' href='#'><i class='material-icons'>info</i></a>
        </span>
    </li>
";

        }
    }
mysqli_free_result ( $db_erg );
  ?>