<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 15.01.17
 * Time: 12:39
 */
session_start();
print_r($_POST);
$pw=$_POST['pw'];
    if($pw==abc){
        $_SESSION['chat_sessionid']="ALPIX";
        header("Location: main.php");
    }
else{
    echo "failed";
}