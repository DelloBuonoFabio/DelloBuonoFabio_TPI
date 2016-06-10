<?php
session_start();
require_once 'application.php';

$error = "";
if (isset($_REQUEST["DeleteConfiguration"])) {
    CleanSession();
    $_SESSION["nomConfiguration"] = filter_input(INPUT_POST, 'nameConfiguration', FILTER_SANITIZE_SPECIAL_CHARS);
}

if (isset($_REQUEST["btnSauvegarder"])){
    if(!empty($_SESSION["Processeur"]) && !empty($_SESSION["CarteMere"]) && !empty($_SESSION["Memoire"]) && !empty($_SESSION["Ventilateur"]) && !empty($_SESSION["Boitier"]) && !empty($_SESSION["Alimentation"]) && !empty($_SESSION["DisqueDur"]) && !empty($_SESSION["CarteGraphique"])){
        if(!empty($_SESSION["Clavier"])){
            $Clavier = $_SESSION["Clavier"]["id_composant"];
        } else {
            $Clavier = "0";
        }
        if(!empty($_SESSION["Souris"])){
            $Souris = $_SESSION["Souris"]["id_composant"];
        } else {
            $Souris = "0";
        }
        if(!empty($_SESSION["LecteurOptique"])){
            $LecteurOptique = $_SESSION["LecteurOptique"]["id_composant"];
        } else {
            $LecteurOptique = "0";
        }
        if(!empty($_SESSION["OS"])){
            $OS = $_SESSION["OS"]["id_composant"];
        } else {
            $OS = "0";
        }
        if(!empty($_SESSION["AntiVirus"])){
            $AntiVirus = $_SESSION["AntiVirus"]["id_composant"];
        } else {
            $AntiVirus = "0";
        }
        
        $listComponent = $_SESSION["Processeur"]["id_composant"] . "," . 
                $_SESSION["CarteMere"]["id_composant"] . "," . 
                $_SESSION["Memoire"]["id_composant"] . "," . 
                $_SESSION["Ventilateur"]["id_composant"] . "," . 
                $_SESSION["Boitier"]["id_composant"] . "," . 
                $_SESSION["Alimentation"]["id_composant"] . "," . 
                $_SESSION["DisqueDur"]["id_composant"] . "," . 
                $_SESSION["CarteGraphique"]["id_composant"] . "," .
                $Clavier . "," . $Souris . "," . $LecteurOptique . "," .
                $OS . "," . $AntiVirus;
                
        AddConfiguration($_SESSION["nomConfiguration"],$listComponent,$_SESSION['user_logged']['id_utilisateur']);
        header('Location: compte.php');
    } else {
        $error = '<div class="alert alert-warning" role="alert"><strong>Oops!</strong>il manque des composants</div>';
    }
}
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
            <div class="panel panel-default col-md-8">
                <?php ShowConfiguration() ?>
            </div>
            <div class="panel panel-default col-md-4">
                <h3>Prix Total : <?php CalculatePrice() ?> CHF</h3>
                <form action="#" method="post">
                    <div class="btn-group btn-group-justified" role="group">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalSupprimer" name="btnSupprimer">Supprimer</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalSauvegrader"  name="btnSauvegarder">Sauvegarder</button>
                        </div>
                    </div>
                </form>
                </br>
                <?php echo $error; ?>
            </div>
            </br>
            <!-- Modal Security -->
            <div class="modal fade" id="ModalSupprimer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="#" method="post" id="registerForm">
                            <div class="modal-header">
                                <div class="alert alert-danger" role="alert"><strong>Attention!</strong> Voulez-vous vraiment supprimer votre configguration ?</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" name="DeleteConfiguration" id="btnYellow" class="btn btn-primary">Supprimer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal Save-->
            <div class="modal fade" id="ModalSauvegrader" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="#" method="post" id="registerForm">
                            <div class="modal-header">
                                <div class="alert alert-success" role="alert"><strong>Super!</strong> Avant de sauvegarder, donné un nom a votre création</div>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" placeholder="Titre Configuration" name='nameConfiguration' required aria-describedby="basic-addon2">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" name="btnSauvegarder" id="btnYellow" class="btn btn-primary">Ajouter</button>
                            </div>
                        </form>
                    </div>
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