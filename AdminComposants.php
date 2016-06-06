<?php
session_start();
require_once 'application.php';


if (isset($_REQUEST["btnAfficher"])) {
    $ThisCategorie = filter_input(INPUT_POST, 'selectCat', FILTER_SANITIZE_SPECIAL_CHARS);
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
                <div class="panel-heading">
                    <h3>Administration Composants</h3>
                </div>
                <div class="panel-body">
                    <h3>Afficher les Composants</h3>
                    <form action="#" method="POST">
                        <select class="form-control" name="selectCat">
                            <option value="ca.nom_categorie">Choisir une catégorie...</option>
                            <?php
                            echo GetCategorrie();
                            ?>
                        </select>
                        </br>
                        <button type="submit" class="btn btn-default btn-cm btn-block" name='btnAfficher'>Afficher</button>
                    </form>
                    </br>
                    <?php
                    echo ShowComponent($ThisCategorie);
                    echo $ThisCategorie;
                    ?>
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