<?php
session_start();
require_once 'application.php';

$categorieName = $_GET['Categorie'];

if(isset($_REQUEST["$categorieName"]))
{
    $_SESSION["$categorieName"] = ShowThisComponent(GetIdByName($categorieName));
    header('Location: configuration.php');
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
            <?php
            if (!empty($categorieName)) {
                ShowThiscategorieWithButton($categorieName);
            } else {
                echo "error";
            }
            ?>
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