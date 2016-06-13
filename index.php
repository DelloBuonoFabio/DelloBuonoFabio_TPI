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
        <!-- CONTENT -->
        <div class="container marketing">
            <h1>
                Bienvenue
            </h1>
            <!-- CONTENT ABOUT-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>À propos</h3>
                </div>
                <div class="panel-body">
                    Beaucoup de gens dans mon entourage mon demandé de l’aide pour leur futur projet d’ordinateur, avec grand plaisir j’ai eu la possibilité de les aider, mais grâce à ce site web, beaucoup de gens pourrons le faire eu même en tout simplicité.                
                </div>
            </div>
            
            <!-- CONTENT MAP-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Où sommes nous</h3>
                </div>
                <div class="panel-body">
                    <form action="" method="get" name="direction" id="direction">
                        <div class="input-group input-group-md form-group" id="test">
                            <input type="text" class="form-control " required placeholder="Point de départ" name='origin' id="origin" aria-describedby="basic-addon2">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" data-toggle="tooltip" title="Géolocalisation" name="texteOrigin" onclick="getPosition('origin')"><span class="glyphicon glyphicon-map-marker" id="petitLogo"></span></button>
                            </span>
                        </div> 
                        <div class="input-group input-group-md form-group">
                            <input type="text" class="form-control" readonly="readonly" value="CFPT Ecole d'Informatique, Chemin Gérard-De-Ternier 10, Lancy" placeholder="Destination" name='destination' id="destination" required aria-describedby="basic-addon2">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button" data-toggle="tooltip" title="Géolocalisation" name="texteDestination"><span class="glyphicon glyphicon-home" id="petitLogo"></span></button>
                            </span>
                        </div>
                        <button type="button" class="btn btn-default btn-sm btn-block" name='btnSubmit' onclick="calculate()" id="petitLogo">Calculer l'itinéraire</button>
                    </form>
                </div>
                <!-- MAP -->
                <div id="Map">
                    <p>Veuillez patienter pendant le chargement de la carte...</p>
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
        <script src="./functions.js"></script>
        <script>initialize();</script>
    </body>
</html>