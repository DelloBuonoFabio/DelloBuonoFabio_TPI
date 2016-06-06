<?php
session_start();
require_once 'application.php';


if (isset($_REQUEST["btnAfficher"])) {
    $ThisCategorie = filter_input(INPUT_POST, 'selectCat', FILTER_SANITIZE_SPECIAL_CHARS);
}

if(isset($_REQUEST["AddComponent"])){
    $nameComponent = filter_input(INPUT_POST, 'nameComponent', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionComponent = filter_input(INPUT_POST, 'descrptionComponent', FILTER_SANITIZE_SPECIAL_CHARS);
    
    $priceComponent = filter_input(INPUT_POST, 'priceComponent', FILTER_SANITIZE_SPECIAL_CHARS);
    $categorieComponent = filter_input(INPUT_POST, 'CatComponent', FILTER_SANITIZE_SPECIAL_CHARS);
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
            <h3>Administration Composants</h3>
            <div class="panel panel-default panel-dropdown">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Afficher les Composants
                        <span class="pull-right glyphicon glyphicon-triangle-top"></span>
                    </h3>
                </div>
                <div class="panel-body">
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
                    if (!empty($ThisCategorie)) {
                        ShowComponent($ThisCategorie);
                    } else {
                        echo "";
                    }
                    ?>
                </div>
            </div>
            <button type="button" class="btn btn-default btn-sm btn-block" name="btnSubmit" data-toggle="modal" data-target="#ModalAjouter">Ajouter un composant</button>

            <!-- Modal Ajouter -->
            <div class="modal fade" id="ModalAjouter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="#" method="post" id="registerForm">
                            <div class="modal-header">
                                <h3>Ajouter un composant</h3>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" placeholder="Nom Composant" required aria-describedby="basic-addon2" name="nameComponent">
                                </br>
                                <textarea style="width: 100%; resize:none; height: 100px;" class="form-control" name="descrptionComponent"></textarea>
                                </br>
                                <label class="btn btn-default btn-file">
                                    Image Composant<input type="file" style="display: none;">
                                </label>
                                <div class="input-group input-group-cm form-group">
                                    <input type="text" class="form-control" placeholder="Prix Composant " required aria-describedby="basic-addon2" name="priceComponent">
                                    <span class="input-group-addon" id="basic-addon2"><span>CHF</span></span>
                                </div> 
                                <select class="form-control" name="CatComponent">
                                    <?php
                                    echo GetCategorrie();
                                    ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" name="AddComponent" id="btnYellow" class="btn btn-primary">Confirmer</button>
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
        <script>
            $(".panel-dropdown").find('.panel-heading').click();
            $('<span>', {
                class: "pull-right glyphicon glyphicon-triangle-bottom"
            }).appendTo($(".panel-dropdown").find('.panel-heading').find('h4'));

            $(".panel-dropdown").find('.panel-heading').click(function () {
                $(this).find('span').toggleClass('glyphicon-triangle-bottom glyphicon-triangle-top');
                $(this).parent(".panel").find(".panel-body").first().slideToggle();
            });
        </script>
    </body>
</html>