<?php
session_start();
require_once 'application.php';

$error = "";
if (isset($_REQUEST["AddComponent"])) {
    $nameComponent = filter_input(INPUT_POST, 'nameComponent', FILTER_SANITIZE_SPECIAL_CHARS);
    $descriptionComponent = filter_input(INPUT_POST, 'descrptionComponent', FILTER_SANITIZE_SPECIAL_CHARS);
    $image = (isset($_REQUEST["pic"]) ? $_REQUEST["pic"] : "");
    $priceComponent = filter_input(INPUT_POST, 'priceComponent', FILTER_SANITIZE_SPECIAL_CHARS);
    $categorieComponent = filter_input(INPUT_POST, 'CatComponent', FILTER_SANITIZE_SPECIAL_CHARS);
    $nomDestination = "default.png";
    AddComponent($nameComponent, $descriptionComponent, $nomDestination, $priceComponent, GetIdByName($categorieComponent));
    ////    $tempo = filter_input(INPUT_POST, 'pic', FILTER_SANITIZE_SPECIAL_CHARS);
//
//    $repertoireDestination = "./images/composant/" . $categorieComponent;
//
//    if (move_uploaded_file($repertoireDestination, $tempo)) {
//
//        AddComponent($nameComponent, $descriptionComponent, $nomDestination, $priceComponent, GetIdByName($categorieComponent));
//        echo "OK";
//    } else {
//        ECHO "nop";
//    }
}

if (isset($_REQUEST["btnAfficher"])) {
    $ThisCategorie = filter_input(INPUT_POST, 'selectCat', FILTER_SANITIZE_SPECIAL_CHARS);
    if (isset($_GET['idComponent'])) {
        $_GET['idComponent'] = "";
    } else {
        
    }
}

if (isset($_GET['idComponent'])) {
    $idComponent = $_GET['idComponent'];
} else {
    $idComponent = "";
}

if (isset($_REQUEST["UpdateComponent"])){
    $NewNameComponent = filter_input(INPUT_POST, 'NewNameComponent', FILTER_SANITIZE_SPECIAL_CHARS);
    $NewDescriptionComponent = filter_input(INPUT_POST, 'NewDescriptionComponent', FILTER_SANITIZE_SPECIAL_CHARS);
    $NewPriceComponent = filter_input(INPUT_POST, 'NewPriceComponent', FILTER_SANITIZE_SPECIAL_CHARS);
    $NewCategorieComponent = filter_input(INPUT_POST, 'NewCatComponent', FILTER_SANITIZE_SPECIAL_CHARS);
    UpdateComponentInformation($_SESSION['ThisComponent']['id_composant'], $NewNameComponent, $NewDescriptionComponent, $NewPriceComponent, GetIdByName($NewCategorieComponent));
}

if (isset($_REQUEST["DeleteComponent"])){
    DeletComponentById(GetIdByName($_SESSION['ThisComponent']['id_composant']));
    header("location:AdminComposants.php");
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
                        <a href="?idComponent="><button type="submit" class="btn btn-default btn-cm btn-block" name='btnAfficher'>Afficher</button></a>
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
            <?php
            if ($idComponent == "") {
                $button = "";
            } else {
                $data = ShowThisComponent($idComponent);
                if ($data != false) {
                    $_SESSION['ThisComponent'] = $data;
                } else {
                    $error = '<div class="alert alert-warning" role="alert"><strong>Oops!</strong> Un problème est survenu</div>';
                }
                $button = '<button type="button" class="btn btn-default btn-sm btn-block" id="btnModifier" name="btnModifier" data-toggle="modal" data-target="#ModalOption">Modifier le composant</button>';
            }
            echo $button;
            echo $error;   
            ?>

            <!-- Modal Ajouter -->
            <div class="modal fade" id="ModalAjouter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="#" method="post" id="registerForm" enctype="multipart/form-data">
                            <div class="modal-header">
                                <h3>Ajouter un composant</h3>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" placeholder="Nom Composant" required aria-describedby="basic-addon2" name="nameComponent">
                                </br>
                                <textarea style="width: 100%; resize:none; height: 100px;" class="form-control" name="descrptionComponent"></textarea>
                                </br>
<!--                                <label class="btn btn-default btn-file">
                                    Image Composant<input type="file" style="display: none;" name="pic" id="pic">
                                </label>-->
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
            <!-- Modal Option -->
            <div class="modal fade" id="ModalOption" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="#" method="post" id="registerForm">
                            <div class="modal-header">
                                <h3>Modification/Suppression</h3>
                            </div>
                            <div class="modal-body">
                                <input type="text" class="form-control" placeholder="Nom Composant" required aria-describedby="basic-addon2" name="NewNameComponent" value="<?php echo $_SESSION['ThisComponent']['nom_composant'] ?>">
                                </br>
                                <textarea style="width: 100%; resize:none; height: 100px;" class="form-control" name="NewDescriptionComponent"><?php echo $_SESSION['ThisComponent']['description_composant'] ?></textarea>
                                </br>
                                <!--IMAGE-->
                                <img src="images/composant/<?php echo GetNameById($_SESSION['ThisComponent']['id_categorie']) ?>/<?php echo $_SESSION['ThisComponent']['photo_composant'] ?>" class="img-rounded"/>
                                </br>
                                <div class="input-group input-group-cm form-group" id="marginTopInput">
                                    <input type="text" class="form-control" placeholder="Prix Composant " required aria-describedby="basic-addon2" name="NewPriceComponent" value="<?php echo $_SESSION['ThisComponent']['prix_composant'] ?>">
                                    <span class="input-group-addon" id="basic-addon2"><span>CHF</span></span>
                                </div> 
                                <select class="form-control" name="NewCatComponent">
                                    <option value="<?php echo GetNameById($_SESSION['ThisComponent']['id_categorie']) ?>"><?php echo GetNameById($_SESSION['ThisComponent']['id_categorie']) ?></option>
                                    <?php
                                    echo GetCategorrie();
                                    ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                                <button type="submit" name="UpdateComponent" id="btnYellow" class="btn btn-primary">Modifier</button>
                                <button type="submit" name="DeleteComponent" id="btnYellow" class="btn btn-primary">Supprimer</button>
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
        <script>
            $("#btnModifier").trigger("click");
        </script>
    </body>
</html>