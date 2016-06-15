<?php
session_start();
require_once 'application.php';

/**************************************
 * Projet :         MyPCConfig
 * Auteur :         Dello Buono Fabio
 * Date :           15.06.2016
 * Description :    Cette page affiche les différentes catégories qui se trouvent sur le site
 **************************************/

?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <?php
        echo AllMeta();
        ?>
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
        <!-- CONTENT -->
        <div class="container marketing">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>les catégories</h3>
                </div>
                <!-- LISTE CATEGORY -->
                <div class="panel-body">
                    <?php
                    ShowCategory();
                    ?>
                </div>
            </div>

            <!-- FOOTER --> 
            <footer>
                <?php
                echo AllFooter()
                ?>
            </footer>
        </div>
        <!-- BOOTSTRAP SCRIPT -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="./BootStrap/js/bootstrap.min.js"></script>
    </body>
</html>