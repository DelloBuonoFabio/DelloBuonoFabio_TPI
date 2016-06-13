<?php
session_start();
require_once 'application.php';

$button = "";
if (isset($_GET['idUser'])) {
    $idUser = $_GET['idUser'];
    $button = '<button type="button" class="btn btn-default btn-sm btn-block" name="btnSubmit" data-toggle="modal" data-target="#ModalSecurity">Supprimer supprimer ce compte</button>';
} else {
    $idUser = "";
    $button = "";
}
if (isset($_REQUEST["DeleteUser"])) {
    DeletUserById($idUser);
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
        <div class="container marketing">
            <!-- CONTENT USERS --> 
            <table class="table">
                <tr>
                    <th>Nom</th><th>Prénom</th><th>Email</th><th>Admin</th><th>Option</th>
                </tr>
                <?php ShowUser() ?>
            </table>
            <?php
            echo $button;
            ?>
            <!-- MODAL SECURITY -->
            <div class="modal fade" id="ModalSecurity" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="#" method="post" id="registerForm">
                            <div class="modal-header">
                                <div class="alert alert-danger" role="alert"><strong>Attention!</strong> Voulez-vous vraiment supprimer ce compte ?</div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" name="DeleteUser" id="btnYellow" class="btn btn-primary">Supprimer</button>
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
    </body>
</html>