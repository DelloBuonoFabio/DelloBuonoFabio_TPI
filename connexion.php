<?php
session_start();
require_once 'application.php';

/**************************************
 * Projet :         MyPCConfig
 * Auteur :         Dello Buono Fabio
 * Date :           15.06.2016
 * Description :    Cette page permet a l'utilisateur de se connecter et de ce créer un compte
 **************************************/

$error = "";

$NewData = [];
if (isset($_REQUEST["modalForm"])) {
    $NewName = filter_input(INPUT_POST, 'NewName', FILTER_SANITIZE_SPECIAL_CHARS);
    $NewFirstName = filter_input(INPUT_POST, 'NewFirstName', FILTER_SANITIZE_SPECIAL_CHARS);
    $NewEmail = filter_input(INPUT_POST, 'NewEmail', FILTER_SANITIZE_SPECIAL_CHARS);
    $NewPassword = filter_input(INPUT_POST, 'NewPassword', FILTER_SANITIZE_SPECIAL_CHARS);
    $NewPasswordConfirmed = filter_input(INPUT_POST, 'NewPasswordConfirmed', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($NewPassword == $NewPasswordConfirmed) {
        $NewData = AddUser($NewName, $NewFirstName, $NewEmail, $NewPassword);
        $error = '<div class="alert alert-success" role="alert"><strong>Parfait!</strong> Le compte a bel et bien été crée, vous pouvez maintenant vous connecter !</div>';
    } else {
        $error = '<div class="alert alert-warning" role="alert"><strong>Oops!</strong> Les mots de passe ne sont pas les même !</div>';
    }

    if ($NewData == "error") {
        $error = '<div class="alert alert-warning" role="alert"><strong>Oops!</strong> Cette adresse email est déjà utilisée !</div>';
    }
}

if (isset($_REQUEST["btnSubmit"])) {
    $UserEmail = filter_input(INPUT_POST, 'UserEmail', FILTER_SANITIZE_SPECIAL_CHARS);
    $UserPassword = filter_input(INPUT_POST, 'UserPassword', FILTER_SANITIZE_SPECIAL_CHARS);
    $data = CheckLogin($UserEmail, $UserPassword);
    if ($data != false) {
        $_SESSION['user_logged'] = $data;
        header('Location: index.php');
    } else {
        $error = '<div class="alert alert-warning" role="alert"><strong>Oops!</strong> Cet utilisateur n\'existe pas !</div>';
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
                echo menu();
                ?>

            </div>
        </div>
        <!-- CONTENT -->
        <div class="container">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Connexion</h3>
                </div>
                <div class="panel-body">
                    <form action="#" method="post">
                <div class="input-group input-group-md form-group">
                    <input type="email" class="form-control" placeholder="Email" name='UserEmail' required aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-user"></span></span>
                </div> 
                <div class="input-group input-group-md form-group">
                    <input type="password" class="form-control" placeholder="Mot de Passe" name='UserPassword' required aria-describedby="basic-addon2">
                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-lock"></span></span>
                </div> 
                <br>
                <button type="submit" class="btn btn-default btn-md btn-block" name='btnSubmit'>Envoyer</button>
            </form>     
            <br>
            <!-- BUTTON MODAL REGISTER-->
            <button type="button" class="btn btn-default btn-md btn-block" data-toggle="modal" data-target="#myModal">
                Créer un compte
            </button>
                </div>
            </div>
            <!-- MODAL REGISTER-->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="connexion.php" method="post" id="registerForm">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title" id="myModalLabel">Enregistrement</h3>
                            </div>
                            <div class="modal-body">
                                <div class="input-group input-group-md form-group">
                                    <input type="text" class="form-control" placeholder="Nom"  name='NewName' required aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-user"></span></span>
                                </div> 
                                <div class="input-group input-group-md form-group">
                                    <input type="text" class="form-control" placeholder="Prenom"  name='NewFirstName' required aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-user"></span>
                                </div> 
                                <div class="input-group input-group-md form-group">
                                    <input type="email" class="form-control" placeholder="Email"  name='NewEmail' required aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-envelope"></span>
                                </div> 
                                <div class="input-group input-group-md form-group">
                                    <input type="password" class="form-control" placeholder="Mot De Passe" name='NewPassword' required aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-lock"></span>
                                </div> 
                                <div class="input-group input-group-md form-group">
                                    <input type="password" class="form-control" placeholder="Confirmer le Mot De Passe" required name='NewPasswordConfirmed' aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-lock"></span>
                                </div> 
                                <p id="texteModal"><span class="glyphicon glyphicon-exclamation-sign"></span> Tous les champs sont requis</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" name="modalForm" id="btnYellow" class="btn btn-primary">Confirmer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </br>
            <?php echo $error; ?>
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
