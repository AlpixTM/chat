<?php
/**
 * Created by PhpStorm.
 * User: lukas
 * Date: 13.01.17
 * Time: 20:25
 */
session_start();
include_once 'dbconnect.php';                                               // DB-Verbindung wird aufgebaut, abrufbar unter "$link"
include_once 'chatFunctions.php';

$logout = $_GET['logout'];

if ($logout == true) {                                                      // Ist true, wenn der Nutzer auf der Hauptseite auf den Logout-Button gedrückt hat
    $name = $_SESSION['chat_sessionid'];                                    // Name wird aus der Session gelesen
    $sql = "UPDATE `user` SET `status` = '0' WHERE `Name`='$name'";         // Status wird auf 0 => offline gesetzt
    mysqli_query($link, $sql);
    session_destroy();                                                      // Session wird zerstört
    header("Location: /");
}

isLoggedIn();
?>
<html lang="de">
<head>
    <title>CHAT</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">
    <meta name="description" content="Chat.">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&amp;lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="material.min.css">

    <!-- Auf dieser Seite kann der Nutzer sich anmelden, registrieren und ein Kontakt-Formular ausfüllen -->

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <style>

        /* Preloader  - Quelle unbekannt */

        #preloader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #fff; /* change if the mask should have another color then white */
            z-index: 99; /* makes sure it stays on top */
        }

        #status {
            width: 200px;
            height: 200px;
            position: absolute;
            left: 50%; /* centers the loading animation horizontally one the screen */
            top: 50%; /* centers the loading animation vertically one the screen */
            background-repeat: no-repeat;
            background-position: center;
            margin: -100px 0 0 -100px; /* is width and height divided by two */
        }

        <!--
        Platz für CSS für jquery UI

        -->
    </style>
    <script>
        //<!--JS Preload - Quelle unbekannt -->

        //<![CDATA[
        $(window).load(function () { // makes sure the whole site is loaded
            $('#status').fadeOut(); // will first fade out the loading animation
            $('#preloader').delay(3).fadeOut('slow'); // will fade out the white DIV that covers the website.
            $('body').delay(3).css({'overflow': 'visible'});
        })
        //]]>

        <!-- Captcha -->
        function onSubmit(token) {
            document.getElementById("a").submit();
        }

        <!-- Platz für js für jquery UI -->
    </script>

</head>
<body class="mdl-base">
<div id="preloader">
    <div id="status">
        <iframe src="loader.html" seamless sandbox="allow-scripts" scrolling="no" frameborder="NO"></iframe>
    </div>
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
            <a href="#fixed-tab-1" class="mdl-layout__tab is-active">Login</a>
            <a href="#fixed-tab-2" class="mdl-layout__tab">Registrieren</a>
            <a href="#fixed-tab-3" class="mdl-layout__tab">Fehler melden</a>
        </div>
    </header>
    <!--  <div class="mdl-layout__drawer">
          <span class="mdl-layout-title">Chat - Login</span>
      </div> -->
    <main class="mdl-layout__content">
        <!-- Hauptcontent -->
        <section class="mdl-layout__tab-panel is-active" id="fixed-tab-1">
            <div class="page-content">
                <!-- Login -->
                <h3 style="text-align: center">Login</h3>
                <div class="mdl-grid">

                    <div class="mdl-layout-spacer"></div>

                    <form id="a" action="login.php" method="post">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="Name" name="Name">
                            <label class="mdl-textfield__label" for="Name">Name...</label>
                        </div>

                        <div class="mdl-layout-spacer"></div>


                        <div class="mdl-layout-spacer"></div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="password" id="pw" name="pw">
                            <label class="mdl-textfield__label" for="pw">Passwort...</label>
                        </div>
                        <div class="mdl-layout-spacer"></div>

                        <div class="mdl-layout-spacer"></div>
                        <div class="mdl-grid">
                            <div class="mdl-layout-spacer"></div>
                            <button class="g-recaptcha mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
                                    data-sitekey="6LdO4REUAAAAAJ5tUklyThfRMmEN8MvCA8UlDsnQ"
                                    data-callback='onSubmit'>
                                Login
                            </button>
                            <div class="mdl-layout-spacer"></div>
                        </div>
                    </form>

                    <div class="mdl-layout-spacer"></div>


                </div>


            </div>
        </section>
        <section class="mdl-layout__tab-panel" id="fixed-tab-2">
            <div class="page-content">
                <!-- Registrierung -->
                <h3 style="text-align: center">Registrieren</h3>
                <div class="mdl-grid">

                    <div class="mdl-layout-spacer"></div>

                    <form id="b" action="register.php" method="post">
                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="NameREG" name="NameREG">
                            <label class="mdl-textfield__label" for="NameREG">Name...</label>
                        </div>

                        <div class="mdl-layout-spacer"></div>


                        <div class="mdl-layout-spacer"></div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="password" id="pwREG" name="pwREG">
                            <label class="mdl-textfield__label" for="pwREG">Passwort...</label>
                        </div>
                        <div class="mdl-layout-spacer"></div>

                        <div class="mdl-layout-spacer"></div>

                        <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                            <input class="mdl-textfield__input" type="text" id="mailREG" name="mailREG">
                            <label class="mdl-textfield__label" for="mailREG">E-Mail...</label>
                        </div>
                        <div class="mdl-layout-spacer"></div>

                        <div class="mdl-layout-spacer"></div>

                        <div class="mdl-grid">
                            <div class="mdl-layout-spacer"></div>
                            <button class=" mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent"
                                    data-sitekey="6LdO4REUAAAAAJ5tUklyThfRMmEN8MvCA8UlDsnQ"
                                    type="submit">
                                Registrieren
                            </button>
                            <div class="mdl-layout-spacer"></div>
                        </div>
                    </form>

                    <div class="mdl-layout-spacer"></div>

                </div>
            </div>
        </section>
        <section class="mdl-layout__tab-panel" id="fixed-tab-3">
            <div class="page-content">
                <!-- Fehler melden -->

                <h3 style="text-align: center">Kontakt</h3>
                <div class="mdl-grid">

                    <div class="mdl-layout-spacer"></div>

                    <form id="c" action="contact.php" method="post">
                        <!-- Floating Multiline Textfield -->
                        <div class="mdl-textfield mdl-js-textfield" style="width: 452px">
                            <textarea class="mdl-textfield__input" type="text" rows="3" id="contact"
                                      name="contact"></textarea>
                            <label class="mdl-textfield__label" for="contact" name="contact">Dein Anliegen.</label>


                        </div>


                        <div class="mdl-layout-spacer"></div>
                        <div class="mdl-layout-spacer"></div>
                        <span class="mdl-chip mdl-chip">
                             <span class="mdl-chip__text">  Bitte teile dein Anliegen mit.Vergiss nicht, einen Kontaktweg anzugeben.</span>
                             <button type="button" class="mdl-chip__action"><i
                                         class="material-icons">cancel</i></button>
                        </span>

                        <div class="mdl-layout-spacer"></div>

                        <div class="mdl-layout-spacer"></div>

                        <div class="mdl-grid">
                            <div class="mdl-layout-spacer"></div>
                            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent">
                                Absenden
                            </button>
                            <div class="mdl-layout-spacer"></div>
                        </div>
                    </form>

                    <div class="mdl-layout-spacer"></div>


                </div>

            </div>
</div>
</section>

<!-- Footer -->

</main>
</div>
<script src="https://code.getmdl.io/1.3.0/material.min.js"></script>
</body>
</html>
