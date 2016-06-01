<?php
session_start();
require_once 'application.php';
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
        <title>HardWare</title>

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
            <!-- LISTE -->
            <div class="panel panel-default panel-dropdown">
                <div class="panel-heading">
                    <h2 class="panel-title">
                        Afficher les catégories
                        <span class="pull-right glyphicon glyphicon-triangle-top"></span>
                    </h2>
                </div>
                <!-- Contenue de la liste -->
                <div class="panel-body">
                    <?php
                    ShowCategorie();
                    ?>
                </div>
            </div>

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
        <script src="./functions.js"></script>
        <script>
            $(".panel-dropdown").find('.panel-heading').click();
            $('<span>', {
                class: "pull-right glyphicon glyphicon-triangle-bottom"
            }).appendTo($(".panel-dropdown").find('.panel-heading').find('h4'));

            $(".panel-dropdown").find('.panel-heading').click(function () {
                $(this).find('span').toggleClass('glyphicon-triangle-bottom glyphicon-triangle-top');
                $(this).parent(".panel").find(".panel-body").first().slideToggle();
            });

        </script>
    </body>
</html>