<?php
session_start();
require_once 'application.php';

$error = "";
if (isset($_REQUEST["modalFormUpdate"])) {
    $UpdateName = filter_input(INPUT_POST, 'UpdateName', FILTER_SANITIZE_SPECIAL_CHARS);
    $UpdateFirstName = filter_input(INPUT_POST, 'UpdateFirstName', FILTER_SANITIZE_SPECIAL_CHARS);
    $UpdateEmail = filter_input(INPUT_POST, 'UpdateEmail', FILTER_SANITIZE_SPECIAL_CHARS);
    $UpdatePassword = filter_input(INPUT_POST, 'UpdatePassword', FILTER_SANITIZE_SPECIAL_CHARS);
    $UpdatePasswordConfirmed = filter_input(INPUT_POST, 'UpdatePasswordConfirmed', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($UpdatePassword == $UpdatePasswordConfirmed) {
        $UpdateData = UpdateUserInformation($_SESSION['user_logged']['nom_utilisateur'], $UpdateFirstName, $UpdateName, $UpdatePassword, $UpdateEmail);
        if ($UpdateData != false) {
            $_SESSION['user_logged'] = $UpdateData;
            header('Location: compte.php');
        } else {
            $error = '<div class="alert alert-warning" role="alert"><strong>Oops!</strong> Les changement ont subis une erreur !</div>';
        }
    }else {
        $error = '<div class="alert alert-warning" role="alert"><strong>Oops!</strong> Les mots de passe ne sont pas les même !</div>';
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
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4>Nom</h4><p><?php echo $_SESSION['user_logged']['nom_utilisateur'] ?></p> 
                    <h4>Prénom</h4><p><?php echo $_SESSION['user_logged']['prenom_utilisateur'] ?></p> 
                    <h4>Email</h4><p><?php echo $_SESSION['user_logged']['email_utilisateur'] ?></p>
                </div>
            </div>
            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalInformation">Mes informations</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalCreation">Mes créations</button>
                </div>
            </div>
            <?php
                echo $error;
            ?>
            </br>
            <button type="button" class="btn btn-default btn-sm btn-block" name='btnSubmit'>Supprimer le compte</button>
            <!-- Modal information -->
            <div class="modal fade" id="ModalInformation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="compte.php" method="post" id="registerForm">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title" id="myModalLabel">Mes Informations</h3>
                            </div>
                            <div class="modal-body">
                                <div class="input-group input-group-lg form-group">
                                    <input type="text" class="form-control" placeholder="Nom" value="<?php echo $_SESSION['user_logged']['nom_utilisateur'] ?>"  name='UpdateName' required aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-user"></span></span>
                                </div> 
                                <div class="input-group input-group-lg form-group">
                                    <input type="text" class="form-control" placeholder="Prenom" value="<?php echo $_SESSION['user_logged']['prenom_utilisateur'] ?>" name='UpdateFirstName' required aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-user"></span>
                                </div> 
                                <div class="input-group input-group-lg form-group">
                                    <input type="email" class="form-control" placeholder="Email" value="<?php echo $_SESSION['user_logged']['email_utilisateur'] ?>"  name='UpdateEmail' required aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-envelope"></span>
                                </div> 
                                <div class="input-group input-group-lg form-group">
                                    <input type="password" class="form-control" placeholder="Mot De Passe" name='UpdatePassword' required aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-lock"></span>
                                </div> 
                                <div class="input-group input-group-lg form-group">
                                    <input type="password" class="form-control" placeholder="Confirmer le Mot De Passe" required name='UpdatePasswordConfirmed' aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-lock"></span>
                                </div> 
                                <p id="texteModal"><span class="glyphicon glyphicon-exclamation-sign"></span> Tous les champs sont requis</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" name="modalFormUpdate" id="btnYellow" class="btn btn-primary">Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal creation -->
            <div class="modal fade" id="ModalCreation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="compte.php" method="post" id="registerForm">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h3 class="modal-title" id="myModalLabel">Mes Créations</h3>
                            </div>
                            <div class="modal-body">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" name="modalForm" id="btnYellow" class="btn btn-primary">Modifier</button>
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