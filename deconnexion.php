<?php
session_start();
$_SESSION = [];
header("Location: index.php");
exit();
session_destroy();

require_once 'application.php';

/* * ************************************
 * Projet :         MyPCConfig
 * Auteur :         Dello Buono Fabio
 * Date :           15.06.2016
 * Description :    Cette page déconnecte l'utilisateur et détruit la session
 * ************************************ */
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="./images/divers/bootstrap.ico">
        <link href="BootStrap/css/bootstrap.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet">
        <title>components</title>

    </head>
    <body>  
        <!-- MENU -->                
        <div class="navbar-wrapper">
            <div class="container">
                <?php
                menu();
                ?>
            </div>
        </div>
        <div class="container">
            <!-- FOOTER --> 
            <footer>
                <p class="pull-right"><a href=""><span class="glyphicon glyphicon-eject"></span></a></p>
                <p>&copy; Dello Buono Fabio</p>
            </footer>
        </div>
        <!-- Bootstrap script  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="./BootStrap/js/bootstrap.min.js"></script>
    </body>
</html>