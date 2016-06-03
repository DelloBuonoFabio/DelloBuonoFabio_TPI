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
                    <h3>Nom</h3><h4><?php echo $_SESSION['user_logged']['nom_utilisateur'] ?></h4> 
                    <h3>Prénom</h3><h4><?php echo $_SESSION['user_logged']['prenom_utilisateur'] ?></h4> 
                    <h3>Email</h3><h4><?php echo $_SESSION['user_logged']['email_utilisateur'] ?></h4>
                </div>
            </div>
            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalInformation">Modifier mes informations</button>
                </div>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#ModalCreation">Afficher mes créations</button>
                </div>
            </div>
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
                                    <input type="text" class="form-control" placeholder="Nom" value="<?php echo $_SESSION['user_logged']['nom_utilisateur'] ?>"  name='NewName' required aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-user"></span></span>
                                </div> 
                                <div class="input-group input-group-lg form-group">
                                    <input type="text" class="form-control" placeholder="Prenom" value="<?php echo $_SESSION['user_logged']['prenom_utilisateur'] ?>" name='NewFirstName' required aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-user"></span>
                                </div> 
                                <div class="input-group input-group-lg form-group">
                                    <input type="email" class="form-control" placeholder="Email" value="<?php echo $_SESSION['user_logged']['email_utilisateur'] ?>"  name='NewEmail' required aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-envelope"></span>
                                </div> 
                                <div class="input-group input-group-lg form-group">
                                    <input type="password" class="form-control" placeholder="Mot De Passe" name='NewPassword' required aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-lock"></span>
                                </div> 
                                <div class="input-group input-group-lg form-group">
                                    <input type="password" class="form-control" placeholder="Confirmer le Mot De Passe" required name='NewPasswordConfirmed' aria-describedby="basic-addon2">
                                    <span class="input-group-addon" id="basic-addon2"><span class="glyphicon glyphicon-lock"></span>
                                </div> 
                                <p id="texteModal"><span class="glyphicon glyphicon-exclamation-sign"></span> Tous les champs sont requis</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" name="modalForm" id="btnYellow" class="btn btn-primary">Modifier</button>
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