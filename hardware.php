<?php
session_start();
require_once 'application.php';
?>
<!DOCTYPE html>
<html lang="en">
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
        <div class="container">
            <!-- PANEL -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>les catégories</h3>
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
                <?php
                echo AllFooter()
                ?>
            </footer>
        </div>
        <!-- Bootstrap script  -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="./BootStrap/js/bootstrap.min.js"></script>
        <script src="./functions.js"></script>
    </body>
</html>