<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 15.01.17
 * Time: 12:49
 */
session_start();

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
	$num = 4;
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
            <span class="mdl-layout-title">Chat - Login</span>
        </div>
        <!-- Tabs -->
        <div class="mdl-layout__tab-bar mdl-js-ripple-effect">
			<a href="#fixed-tab-1" class="mdl-layout__tab is-active"><span class="mdl-badge" data-badge="  <?php show_badge_num(1); ?>">Raum 1 </span></a>
            <a href="#fixed-tab-2" class="mdl-layout__tab"><span class="mdl-badge" data-badge=" <?php show_badge_num(2); ?>">Raum 2 </span></a>
            <a href="#fixed-tab-3" class="mdl-layout__tab"><span class="mdl-badge" data-badge="  <?php show_badge_num(3); ?>">Raum 3 </span></a>
<!--			<a href="#fixed-tab-1" class="mdl-layout__tab is-active"><span class="mdl-badge" data-badge="3">Raum 1 </span></a>
            <a href="#fixed-tab-2" class="mdl-layout__tab"><span class="mdl-badge" data-badge="2">Raum 2 </span></a>
            <a href="#fixed-tab-3" class="mdl-layout__tab"><span class="mdl-badge" data-badge="7">Raum 3 </span></a> -->
        </div>
    </header>
    <main class="mdl-layout__content">
<!-- Haupcontent -->
        <section class="mdl-layout__tab-panel is-active" id="fixed-tab-1">
            <div class="page-content">
                <!-- Raum 1 -->
				  <div class="mdl-grid">


       <div class="mdl-layout-spacer"></div>
	 <iframe src="loader.html"></iframe>
	         <div class="mdl-layout-spacer"></div>
		
</div>
	
            </div>
        </section>
        <section class="mdl-layout__tab-panel" id="fixed-tab-2">
            <div class="page-content">
                <!-- Raum 2 -->
               
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
