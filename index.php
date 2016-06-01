<?php
session_start();
require_once 'application.php';
?>
<!DOCTYPE html>
<html lang="fr">
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
            <div class="container animation-target">
                <?php
                menu();
                ?>
            </div>
        </div>
        <div class="container">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- INDICATORS -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>

                <!-- IMG -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="images/divers/HardWareWallpaper1.jpg" alt="WallpaperHardWare">
                        <div class="carousel-caption">
                        </div>
                    </div>
                    <div class="item">
                        <img src="images/divers/HardWareWallpaper2.jpg" alt="WallpaperHardWare">
                        <div class="carousel-caption">
                        </div>
                    </div>
                    <div class="item">
                        <img src="images/divers/HardWareWallpaper3.jpg" alt="WallpaperHardWare">
                        <div class="carousel-caption">
                        </div>
                    </div>
                </div>       
                <!-- CONTROLS -->
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                </a>
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
    </body>
</html>