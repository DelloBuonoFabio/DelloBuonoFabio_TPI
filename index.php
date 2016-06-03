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
        <script
            src="http://maps.googleapis.com/maps/api/js">
        </script>
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
            <h1>
                Bienvenue
            </h1>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>À propos</h3>
                </div>
                <div class="panel-body">
                    Le Lorem Ipsum est simplement du faux texte employé dans la composition et la mise en page avant impression. Le Lorem Ipsum est le faux texte standard de l'imprimerie depuis les années 1500, quand un peintre anonyme assembla ensemble des morceaux de texte pour réaliser un livre spécimen de polices de texte.
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Où sommes nous</h3>
                </div>
                <div class="panel-body">
                    <form action="" method="get" name="direction" id="direction">
                        <div class="input-group input-group-lg form-group" id="test">
                            <input type="text" class="form-control" required placeholder="Point de départ" name='origin' id="origin" aria-describedby="basic-addon2">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" data-toggle="tooltip" title="Géolocalisation" name="texteOrigin" onclick="getPosition('origin')"><span class="glyphicon glyphicon-map-marker" id="petitLogo"></span></button>
                            </span>

                        </div> 
                        <div class="input-group input-group-lg form-group">
                            <input type="text" class="form-control" readonly="readonly" value="CFPT Ecole d'Informatique, Chemin Gérard-De-Ternier 10, Lancy" placeholder="Destination" name='destination' id="destination" required aria-describedby="basic-addon2">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" data-toggle="tooltip" title="Géolocalisation" name="texteDestination"><span class="glyphicon glyphicon-home" id="petitLogo"></span></button>
                            </span>
                        </div>
                        <button type="button" class="btn btn-default btn-lg btn-block" name='btnSubmit' onclick="calculate()" id="petitLogo">Calculer l'itinéraire</button>
                    </form>
                </div>
                <!-- MAP -->
            <div id="Map">
                <p>Veuillez patienter pendant le chargement de la carte...</p>
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
        <script>initialize();</script>
    </body>
</html>