<?php
session_start();
require_once 'application.php';
$_SESSION["Configuration"] = []
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
            <div class="panel panel-default col-md-9">

                <div class="panel-heading">
                    <h2 class="panel-title">Processeur</h2>
                </div>
                <div class="panel-body" class="texte-configuration">
                    <img src=" <?php
                    if (empty($_SESSION["Processeur"])) {
                        echo 'images/composant/default.png';
                    } else {
                        echo 'images/composant/Processeur/' . $_SESSION["Processeur"]['photo_composant'] . '';
                    }
                    ?>" class="img-thumbnail" style="width: 80px;">
                         <?php
                         if (empty($_SESSION["Processeur"])) {
                             echo '<a href="composant.php?Categorie=Processeur"><h4 id="h4Border">Veuillez choisir un Processeur</h4></a>';
                         } else {
                             echo '<h4>' . $_SESSION["Processeur"]["nom_composant"] . '</h4>';
                             echo '<h4 id="h4Border">' . $_SESSION["Processeur"]["prix_composant"] . ' CHF</h4>';
                         }
                         ?>

                </div>
                <?php ShowConfiguration() ?>
            </div>
            <div class="panel panel-default col-md-3">
                <p>Prix</p>
             <?php // echo $_SESSION["Processeur"]["prix_composant"] ?>
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