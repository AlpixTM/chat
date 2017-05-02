<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 15.01.17
 * Time: 12:49
 */
session_start();
include_once 'dbconnect.php';
if ($_SESSION['chat_sessionid']) {
  // echo "logged in ";
  $sesion=$_SESSION['chat_sessionid'];
}
else {
    print_r($_SESSION);
    header("Location: https://chat.alpix.eu/");
    die("Bitte neu einloggen");
}
function show_badge_num ($num){
	$num =rand(3,9);
	echo $num;
}
?>
<html lang="de">
<head>
    <title>CHAT</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="description" content="Chat.">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="material.min.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script  src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <style>

        /* Preloader  - Quelle unbekannt */

        #preloader {
            position:fixed;
            top:0;
            left:0;
            right:0;
            bottom:0;
            background-color:#fff; /* change if the mask should have another color then white */
            z-index:99; /* makes sure it stays on top */
        }

        #status {
            width:200px;
            height:200px;
            position:absolute;
            left:50%; /* centers the loading animation horizontally one the screen */
            top:50%; /* centers the loading animation vertically one the screen */
            background-repeat:no-repeat;
            background-position:center;
            margin:-100px 0 0 -100px; /* is width and height divided by two */
        }
        <!-- Platz für CSS für jquery UI -->
    </style>
    <script>
        <!-- JS Preload - Quelle unbekannt -->
		
        //<![CDATA[
        $(window).load(function() { // makes sure the whole site is loaded
            $('#status').fadeOut(); // will first fade out the loading animation
            $('#preloader').delay(3).fadeOut('slow'); // will fade out the white DIV that covers the website.
            $('body').delay(3).css({'overflow':'visible'});
        })
        //]]>

        <!-- Platz für js für jquery UI -->

        <!-- JS Funktionen -->


        window.setInterval(function(){
          updateelement('room2');
          console.log("Chat erfolgreich neu geladen");
          updateelement("onlist");
          console.log("OnlineListe erfolgreich neu geladen");
        }, 5000);

        function updateelement(id) {
          $('#' + id).load(document.URL +  ' #' +id);
        }
        jQuery(document).ready(function(){
            $("#onlistbutton").click(function() {
                $("#onlist").toggle();
            });
        });

        function send (id) {
            var message = document.getElementById(id).value;
            var rooomid = id.substr(4); // String muss Format "RoomXxxx" erfüllen um X zu bekommen
            console.log(rooomid);
            var typeid = 1;
            var posting = $.post( "ReST/send.php", { message: message,roomid: rooomid,typeid: typeid} );
            posting.done(function( data ) {
                if (data == "success"){
                    console.log("Success");
                    document.getElementById(id).value = "";
                    updateelement("room2");
                }
                else {
                    console.log("Failed ID:" + data);
                }
            });
        }

    </script>

</head>
<body class="mdl-base">
<div id="preloader">
    <div id="status">    <iframe src="loader.html" seamless sandbox="allow-scripts"></iframe> </div>
</div>
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header mdl-layout--fixed-tabs">
    <!-- Header -->
    <header class="mdl-layout__header">
        <div class="mdl-layout__header-row">
            <!-- Title -->
            <button onclick="location.href='https://chat.alpix.eu/index.php?logout=true';"  class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored">
                <i class="material-icons">exit_to_app</i>
            </button>  <span class="mdl-layout-title">Chat</span>
        </div>
        <!-- Tabs -->
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
            <!--   	<a href="#fixed-tab-1" class="mdl-layout__tab is-active"><span class="mdl-badge" data-badge="  <?php show_badge_num(1); ?>">Raum 1 </span></a>-->
       <a href="#fixed-tab-2" class="mdl-layout__tab"><span class="mdl-badge" >Hauptraum </span></a>
        <!--        <a href="#fixed-tab-3" class="mdl-layout__tab"><span class="mdl-badge" data-badge="  <?php show_badge_num(3); ?>">Raum 3 </span></a> -->
    </header>
    <main class="mdl-layout__content">
<!-- Haupcontent -->
        <section class="mdl-layout__tab-panel" id="fixed-tab-1">
            <div class="page-content">
                <!-- Raum 1 -->
				  <div class="mdl-grid">


                      <div class="mdl-layout-spacer"></div>
                      <iframe style="margin: auto; position: absolute; top: 0; left: 0; bottom: 0; right: 0;"  src="loader.html" seamless></iframe>
                      <div class="mdl-layout-spacer"></div>
		
</div>
	
            </div>
        </section>
        <section class="mdl-layout__tab-panel is-active" id="fixed-tab-2">
            <div class="page-content">
               <div class="mdl-grid">

<div id="onlistdiv">                   <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="onlistbutton">
        Verbergen / Anzeigen
    </button>
                   <ul class="mdl-list" id="onlist">
                       <li style="text-align: center;"> Nutzer online in diesem Raum</li>
                       <li class="mdl-list__item mdl-list__item--two-line">
    <span class="mdl-list__item-primary-content">
      <i class="material-icons mdl-list__item-avatar"><img style="height: 40px; width: 40px; box-sizing: border-box; border-radius: 50%; background-color: rgb(117, 117, 117); font-size: 40px; color: rgb(255, 255, 255);" src="https://www.xing.com/image/b_3_2_6cf9a06b9_10799605_4/matthias-person-foto.256x256.jpg"></i>
      <span>TEST_USER</span>
      <span class="mdl-list__item-sub-title">online</span>
    </span>
                           <span class="mdl-list__item-secondary-content">
      <a class="mdl-list__item-secondary-action" href="#"><i class="material-icons">info</i></a>
    </span>
                       </li>





                       <?php
                       include 'includes/onlinelist.php';
                       ?>

                   </ul></div>
                   <div class="mdl-layout-spacer"> </div>
<div1 style="overflow: auto;">
    <br>
    <br>
                   <div id="room2" style="overflow: auto;">

                       <table class="mdl-data-table mdl-js-data-table" style="display: table-row;overflow: auto;">
                           <thead>
                           <tr>
                               <th class="mdl-data-table__cell">Uhrzeit</th>
                               <th style=>Name</th>
                               <th style="
    max-width: 50%;
">Nachricht</th>
                           </tr>
                           </thead>
                           <tbody>

                           <?php
                           include 'includes/messages.php';
                           ?>
                           </tbody>
                       </table>
                   </div>

                   <br>
               <form  action="" method="get" onsubmit="send('room2in');return false;">
                       <div class="mdl-textfield mdl-js-textfield" style="width: 100%;">
                           <input class="mdl-textfield__input" type="text" id="room2in">
                           <label class="mdl-textfield__label" for="sample1">Nachricht...</label>
                       </div>
                   </form>
                   </div1>
			   <div class="mdl-layout-spacer"> </div>


			   </div>
            </div>
        </section>
        <section class="mdl-layout__tab-panel" id="fixed-tab-3">
            <div class="page-content">
                <!-- Raum 3 -->

            </div>
        </section>

 <!-- Footer -->

    </main>
</div>
<script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>
