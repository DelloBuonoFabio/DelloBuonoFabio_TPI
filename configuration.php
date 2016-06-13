<?php
session_start();
require_once 'application.php';

$error = "";

if (isset($_REQUEST["DeleteConfiguration"])) {
    ClearSession();
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
        $_SESSION["nomConfiguration"] = filter_input(INPUT_POST, 'nameConfiguration', FILTER_SANITIZE_SPECIAL_CHARS);
        $priceConfiguration = CalculatePrice();
        $Components = [
            $_SESSION["Processeur"]["id_composant"],
            $_SESSION["CarteMere"]["id_composant"],
            $_SESSION["Memoire"]["id_composant"],
            $_SESSION["Ventilateur"]["id_composant"],
            $_SESSION["Boitier"]["id_composant"],
            $_SESSION["Alimentation"]["id_composant"],
            $_SESSION["DisqueDur"]["id_composant"],
            $_SESSION["CarteGraphique"]["id_composant"],
            $Clavier,
            $Souris,
            $LecteurOptique,
            $OS,
            $AntiVirus
        ];

        AddConfiguration($priceConfiguration, $Components,$_SESSION["nomConfiguration"],  $_SESSION['user_logged']['id_utilisateur']);
        
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
        <!-- CONTENT --> 
        <div class="container marketing" id="printableArea">
            <!-- CONTENT CONFIGURATION -->
            <div class="panel panel-default col-md-8">
                <?php ShowConfiguration() ?>
            </div>
            <!-- CONTENT INFORMATION/OPTION -->
            <div class="panel panel-default col-md-4">
                <h3>Prix Total : <?php echo CalculatePrice() ?> CHF</h3>
                <form action="#" method="post">
                    <div class="btn-group btn-group-justified hidden-print" role="group">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalSupprimer" name="btnSupprimer">Supprimer</button>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalSauvegrader"  name="btnSauvegarder">Sauvegarder</button>
                        </div>
                    </div>
                    </br>
                    <input name="print" type="button" class="btn btn-default btn-md btn-block hidden-print" onclick="printDiv('printableArea')" value="Imprimer" />
                </form>
                </br>
                <?php echo $error; ?>
            </div>
            </br>
            <!-- MODAL SECURITY -->
            <div class="modal fade" id="ModalSupprimer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="#" method="post" id="registerForm">
                            <div class="modal-header">
                                <div class="alert alert-danger" role="alert"><strong>Attention!</strong> Voulez-vous vraiment supprimer votre configuration ?</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" name="DeleteConfiguration" id="btnYellow" class="btn btn-primary">Supprimer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- MODAL SAVE CREATION-->
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
        <!-- BOOTSTRAP SCRIPT -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        <script src="./BootStrap/js/bootstrap.min.js"></script>
        <script>
            function printDiv(divName) {
                var printContents = document.getElementById(divName).innerHTML;

                document.body.innerHTML = printContents;

                window.print();
            }
        </script>
    </body>
</html>