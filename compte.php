<?php
session_start();
require_once 'application.php';
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
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Nom</h3><h4>Dello Buono</h4> 
                    <h3>Prénom</h3><h4>Fabio</h4> 
                    <h3>Email</h3><h4>fabio@gmail.com</h4>
                </div>
            </div>
            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default">Modifier mes informations</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default">Afficher mes créations</button>
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
    </body>
</html>