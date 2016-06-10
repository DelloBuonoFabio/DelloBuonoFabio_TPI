<?php
session_start();
require_once 'application.php';
//echo CreatSessionArray();

if (isset($_REQUEST["DeleteConfiguration"])) {
    CleanSession();
    $_SESSION["nomConfiguration"] = filter_input(INPUT_POST, 'nameConfiguration', FILTER_SANITIZE_SPECIAL_CHARS);
}

if (isset($_REQUEST["btnSauvegarder"])){
    
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
                <h3>Prix Total : <?php CalculatePrince() ?> CHF</h3>
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
                                <button type="submit" name="DeleteConfiguration" id="btnYellow" class="btn btn-primary">Supprimer</button>
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