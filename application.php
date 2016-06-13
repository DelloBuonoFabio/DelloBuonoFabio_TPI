<?php

/**
 * Connexion à la base de données 
 * @staticvar type $maDB
 * @return  DB
 */
function connectDB() {
    static $maDB = null;
    $myDBname = "mypcconfig_tpi";
    $myDbnameUser = "AdminLocal";
    $myDBmdpUser = "Super";
    try {
        if ($maDB == null) {
            $maDB = new PDO("mysql:host=localhost;dbname=$myDBname;charset=utf8", $myDbnameUser, // username 
                    $myDBmdpUser, // mdp 
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false));
        }
    } catch (Exception $e) {
        die("Error DataBase -> " . $e->getMessage());
    }
    return $maDB;
}

/**
 * Création et affichage du menu en fonction de l'utilisateur connecté
 */
function menu() {
    //$PageName = contien le nom de la page sur laquelle se trouve l'utilisateur
    $PageName = basename($_SERVER["PHP_SELF"]);

    if (empty($_SESSION['user_logged'])) {
        //si l'utilisateur n'es pas connecté
        $menu = array("index.php" => 'Accueil <span class="glyphicon glyphicon-home"></span>',
            "connexion.php" => 'Connexion <span class="glyphicon glyphicon-user"></span>',
            "hardware.php" => 'HardWare <span class="glyphicon glyphicon-wrench"></span>'
        );
    } else {
        //si l'utilisateur est connecté et l'utilisateur est un admin
        if ($_SESSION['user_logged']['estAdmin']) {
            $menu = array("index.php" => 'Home <span class="glyphicon glyphicon-home"></span>',
                "hardware.php" => 'HardWare <span class="glyphicon glyphicon-wrench"></span>',
                "configuration.php" => 'Configuration <span class="glyphicon glyphicon-cog"></span>',
                "AdminUtilisateur.php" => 'Admin. Utilisateur <span class="glyphicon glyphicon-user"></span>',
                "AdminComposants.php" => 'Admin. Composants <span class="glyphicon glyphicon-tags"></span>',
                "deconnexion.php" => 'Deconnexion <span class="glyphicon glyphicon-remove"></span>'
            );
        } else {
            //si l'utilisateur est connecté mais il n'est pas admin
            $menu = array("index.php" => 'Home <span class="glyphicon glyphicon-home"></span>',
                "hardware.php" => 'HardWare <span class="glyphicon glyphicon-wrench"></span>',
                "configuration.php" => 'Configuration <span class="glyphicon glyphicon-cog"></span>',
                "compte.php" => 'Mon Compte <span class="glyphicon glyphicon-user"></span>',
                "deconnexion.php" => 'Deconnexion <span class="glyphicon glyphicon-remove"></span>'
            );
        }
    }
    //affichage des tableau ci dessus en php et html -> le menu 
    ?>
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container"><div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">My PC Config</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="nav navbar-nav">
                    <?php
                    //echo the menu
                    foreach ($menu as $url => $label) {
                        if ($PageName == $url) {
                            echo "<li class='active'><a class='' href='$url'>$label</a></li>";
                        } else {
                            echo "<li><a href='$url'>$label</a></li>";
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <?php
}

/**
 * Donne à chaque page les metas importantes
 * @return string
 */
function AllMeta() {
    $localMeta = '
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="description" content="HardWare">
        <meta name="author" content="Dello Buono Fabio">
        <link rel="icon" href="./images/divers/logo.ico">
        <link href="BootStrap/css/bootstrap.css" rel="stylesheet">
        <link href="./css/style.css" rel="stylesheet">
        <title>My PC Config</title>';
    return $localMeta;
}

/**
 * Donne à chaque page le footer
 * @return string
 */
function AllFooter() {
    $localFooter = '
        <p class="pull-right hidden-print"><a href=""><span class="glyphicon glyphicon-eject"></span></a></p>
        <p class="hidden-print">Dello Buono Fabio</p>';
    return $localFooter;
}

/**
 * Ajout un nouvel utilisateur dans la base de données
 * @staticvar type $maRequete
 * @param type $name
 * @param type $firstname
 * @param type $email
 * @param type $password
 * @return OK si l'ajout a fonctionné, error si un erreur est survenue
 */
function AddUser($name, $firstname, $email, $password) {
    static $maRequete = null;
    $error = "";
    $admin = false;
    $newMDP = sha1($password);

    //Prépaper la requête lors du premier appel
    if ($maRequete == null) {
        $maRequete = connectDB()->prepare("INSERT INTO t_utilisateur (nom_utilisateur, prenom_utilisateur, email_utilisateur, motDePasse_utilisateur, estAdmin)
                                                VALUES               (              ?,                  ?,                 ?,                      ?,        ?)");
    }

    try {
        //Enregistrer les données
        $maRequete->execute(array($name, $firstname, $email, $newMDP, $admin));
        $error = "OK";
    } catch (Exception $e) {
        $error = "error";
    }
    return $error;
}

/**
 * Vérifie si l'utilisateur se trouve dans la base de données
 * @param string $email
 * @param string $password
 */
function CheckLogin($email, $password) {
    $dtb = connectDB();
    //Encode $password en sha1
    $password = sha1($password);
    //Prépaper la requête lors du premier appel
    $sql = "SELECT * FROM t_utilisateur WHERE email_utilisateur = ? AND motDePasse_utilisateur = ? ";
    //Appeller la requête
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array($email, $password));
    $data = $maRequete->fetch(PDO::FETCH_ASSOC);
    //Retourne les données de l'utilisateur
    return $data;
}

/**
 * Affiche toutes les catégories se trouvant dans la base de données
 */
function ShowCategory() {
    $dtb = connectDB();
    //Prépaper la requête lors du premier appel
    $sql = "Select nom_categorie from t_categorie where 1";
    //Appelle la requête
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array());
    while ($data = $maRequete->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $data;
    }

    //Pour chaque catégories
    echo '<table class="table">';
    foreach ($return as $value) {
        echo '<tr class="listeCategorie">';
        echo '<td>' . $value["nom_categorie"] . '<p class="pull-right"><a href="composant.php?Categorie=' . $value["nom_categorie"] . '"><span class="glyphicon glyphicon-tag"></span></a></p></td>';

        echo '</tr>';
    }
    echo '</table>';
}

/**
 * Affiche les composants d'une catégorie précise 
 * @param type $categorieName
 */
function ShowThisCategory($categorieName) {
    $dtb = connectDB();
    $location = "./images/composant/";
    $sql = 'SELECT `nom_composant`, `photo_composant`, `prix_composant`, `nom_categorie` FROM t_composant co,t_categorie ca where ca.id_categorie = co.id_categorie and ca.nom_categorie ="' . $categorieName . '" ';
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array());
    while ($data = $maRequete->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $data;
    }

    echo '<table class="table">';
    foreach ($return as $value) {
        echo '<tr class="listeCategorie">';
        echo '<td><img src=' . $location . $value["nom_categorie"] . '/' . $value["photo_composant"] . ' alt=' . $value["nom_composant"] . ' class="img-rounded"/></td>';
        echo '<td><h3>' . $value["nom_composant"] . '</h3></td>';
        echo '<td><h3>' . $value["prix_composant"] . ' CHF </h3></td>';
        echo '</tr>';
    }
    echo '</table>';
}

/**
 * Affiche les composants d'une catégorie précise avec un bouton pour 
 * pouvoir l'ajouter à la configuration
 * @param type $categorieName
 */
function ShowThisCategoryWithButton($categorieName) {
    $dtb = connectDB();
    $location = "./images/composant/";
    $sql = 'SELECT `nom_composant`, `photo_composant`, `prix_composant`, `nom_categorie`, `id_composant` FROM t_composant co,t_categorie ca where ca.id_categorie = co.id_categorie and ca.nom_categorie ="' . $categorieName . '" ';
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array());
    while ($data = $maRequete->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $data;
    }
    echo '<form action="#" method="post">';
    echo '<table class="table">';
    foreach ($return as $value) {
        echo '<tr class="listeCategorie">';
        echo '<td><img src=' . $location . $value["nom_categorie"] . '/' . $value["photo_composant"] . ' alt=' . $value["nom_composant"] . ' class="img-rounded"/></td>';
        echo '<td><h3>' . $value["nom_composant"] . '</h3></td>';
        echo '<td><h3>' . $value["prix_composant"] . ' CHF </h3></td>';
        echo '<td><a href="composant.php?Categorie=' . $value["nom_categorie"] . '&&idComposant=' . $value["id_composant"] . '"><button type="button" class="btn btn-default btn-md btn-block" name=' . $value["nom_categorie"] . ' style ="margin-top: 20px;">Ajouter</button></td></a>';
        echo '</tr>';
    }
    echo '</table>';
    echo '</form>';
}

/**
 * Affiche la configuration que l'utilisateur crée depuis la session
 */
function ShowConfiguration() {
    $dtb = connectDB();
    $sql = "Select nom_categorie from t_categorie where 1";
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array());
    while ($data = $maRequete->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $data;
    }

    foreach ($return as $value) {
        $text = "";
        $img = "images/composant/default.png";
        $prix = "0";
        $nom = "";
        $lien = "";
        if (isset($_SESSION[$value["nom_categorie"]])) {
            //si le composant de la catégorie n'existe pas 
            if (empty($_SESSION[$value["nom_categorie"]]["nom_composant"])) {
                $img = "images/composant/default.png";
                $prix = "0";
                $nom = "";
                $lien = "";
                $text = '<a href="composant.php?Categorie=' . $value["nom_categorie"] . '"><h4>Veuillez choisir un(e) ' . $value["nom_categorie"] . '</h4></a>';
            } else {
                //sinon
                $img = 'images/composant/' . $value["nom_categorie"] . '/' . $_SESSION[$value["nom_categorie"]]["photo_composant"] . '';
                $prix = $_SESSION[$value["nom_categorie"]]["prix_composant"];
                $nom = $_SESSION[$value["nom_categorie"]]["nom_composant"];
                $lien = '<a href="composant.php?Categorie=' . $value["nom_categorie"] . '" class="hidden-print"><h4 style="color: #ffffff;">Modifier</h4></a>';
            }
        } else {
            $text = '<a href="composant.php?Categorie=' . $value["nom_categorie"] . '"><h4>Veuillez choisir un(e) ' . $value["nom_categorie"] . '</h4></a>';
        }

        //affichage des informations
        echo '<div class="panel-heading">
                    <h3 class="panel-title" id="h4Border">';
        echo $value["nom_categorie"];
        echo '</h3>';
        echo '</div>
            <div class="panel-body" class="texte-configuration">';

        echo '<table class="table">';
        echo '<tr>';
        echo '<td>';
        echo '<img src="' . $img . '" class="img-thumbnail" style="width: 80px;" alt="img"/>';
        echo '</td>';
        echo '<td>';
        echo '<h4>' . $nom . '</h4>';
        echo '</td>';
        echo '<td>';
        echo '<h4>' . $prix . ' CHF</h4>';
        echo '</td>';
        echo '<td>';
        echo $lien;
        echo '</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td colspan = 4 class="noBorder">';
        echo $text;
        echo '</td>';
        echo '</tr>';
        echo '</table>';

        echo '</div>';
    }
}

/**
 * Affiche tous les utilisateurs qui se trouvent dans la base de données
 */
function ShowUser() {
    $dtb = connectDB();
    $sql = "Select * from t_utilisateur where 1";
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array());
    while ($data = $maRequete->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $data;
    }

    foreach ($return as $value) {
        echo '<tr>';
        echo '<td>' . $value["nom_utilisateur"] . '</td>';
        echo '<td>' . $value["prenom_utilisateur"] . '</td>';
        echo '<td>' . $value["email_utilisateur"] . '</td>';
        echo '<td>' . $value["estAdmin"] . '</td>';
        echo '<td><a href="AdminUtilisateur.php?idUser=' . $value["id_utilisateur"] . '"><span class="glyphicon glyphicon-trash"></span></a></td>';
        echo '</tr>';
    }
}

/**
 * Met à jour les informations de l'utilisateur, puis recharge les informations modifiés
 * @param type $currentUser
 * @param type $newFirstName
 * @param type $newName
 * @param type $newPassword
 * @param type $newEmail
 * @return type
 */
function UpdateUserInformation($currentUser, $newFirstName, $newName, $newPassword, $newEmail) {

    $dtb = connectDB();

    $newPassword = sha1($newPassword);

    $sqlUpdate = ("UPDATE t_utilisateur
                SET nom_utilisateur=?, prenom_utilisateur=?,motDePasse_utilisateur=?,email_utilisateur=?
                WHERE nom_utilisateur=?;");

    $maRequete = $dtb->prepare($sqlUpdate);
    $maRequete->execute(array($newName, $newFirstName, $newPassword, $newEmail, $currentUser));

    $sql = "SELECT * FROM t_utilisateur WHERE email_utilisateur = ?";
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array($newEmail));
    $data = $maRequete->fetch(PDO::FETCH_ASSOC);
    return $data;
}

/**
 * Supprime l'utilisateur en fonction de son email 
 * @param type $EmailUser
 */
function DeletUser($EmailUser) {
    $dtb = connectDB();
    $MaRequete = $dtb->prepare("DELETE FROM t_utilisateur WHERE email_utilisateur=?");
    $MaRequete->execute(array($EmailUser));
}

/**
 * Affiche toutes les catégories sous forme d'options
 */
function GetCategory() {
    $dtb = connectDB();
    $sql = "Select nom_categorie from t_categorie where 1";
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array());
    while ($data = $maRequete->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $data;
    }

    foreach ($return as $value) {
        echo '<option value="' . $value["nom_categorie"] . '">' . $value["nom_categorie"] . '</option>';
    }
}

/**
 * Affiche toutes les informations des composant se trouvant dans une catégorie précise
 * @param type $categorieName
 */
function ShowComponent($categorieName) {
    $dtb = connectDB();
    $location = "./images/composant/";
    if ($categorieName == "ca.nom_categorie") {
        $tempo = "";
    } else {
        $tempo = '"';
    }
    $sql = 'SELECT `id_composant`,`nom_composant`, `photo_composant`, `prix_composant`, `nom_categorie` FROM t_composant co,t_categorie ca where ca.id_categorie = co.id_categorie and ca.nom_categorie = ' . $tempo . $categorieName . $tempo . ' ';
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array());
    while ($data = $maRequete->fetch(PDO::FETCH_ASSOC)) {
        $tableau[] = $data;
    }

    echo '<table class="table">';
    foreach ($tableau as $value) {
        echo '<tr class="listeCategorie">';
        echo '<td><img src=' . $location . $value["nom_categorie"] . '/' . $value["photo_composant"] . ' alt=' . $value["nom_composant"] . ' class="img-rounded"/></td>';
        echo '<td><h3>' . $value["nom_composant"] . '</h3></td>';
        echo '<td><h3>' . $value["prix_composant"] . ' CHF </h3></td>';
        echo '<td><a href="?idComponent=' . $value["id_composant"] . '"><button type="button" name="btnOption" ><span class="glyphicon glyphicon-cog"></span></button></a></td>';
        echo '</tr>';
    }
    echo '</table>';
}

/**
 * Permet d'ajouter un composant dans la base de données
 * @staticvar type $maRequete
 * @param type $nameComponent
 * @param type $descrptionComponent
 * @param type $imgComponent
 * @param type $priceComponent
 * @param type $categorieComponent
 * @return string
 */
function AddComponent($nameComponent, $descrptionComponent, $imgComponent, $priceComponent, $categorieComponent) {
    static $maRequete = null;
    $error = "";

    //Prépaper la requête lors du premier appel
    if ($maRequete == null) {
        $maRequete = connectDB()->prepare("INSERT INTO t_composant (nom_composant, description_composant, photo_composant, prix_composant, id_categorie)
                                                VALUES             (            ?,                ?,               ?,              ?,            ?)");
    }

    try {
        //Enregistrer les données
        $maRequete->execute(array($nameComponent, $descrptionComponent, $imgComponent, $priceComponent, $categorieComponent));
        $error = "OK";
    } catch (Exception $e) {
        $error = "error";
    }
    return $error;
}

/**
 * Récupère l'id du composant grâce au nom
 * @param type $categorieComponent
 * @return type
 */
function GetIdByName($categorieComponent) {
    $dtb = connectDB();
    $maRequete = $dtb->prepare('SELECT id_categorie FROM t_categorie WHERE nom_categorie = "' . $categorieComponent . '"');
    $maRequete->execute(array());
    $data = $maRequete->fetchColumn();
    return $data;
}

/**
 * Supprimer un utilisateur grâce à son id
 * @param type $idUser
 */
function DeletUserById($idUser) {
    $dtb = connectDB();
    $MaRequete = $dtb->prepare('DELETE FROM t_utilisateur WHERE id_utilisateur=?');
    $MaRequete->execute(array($idUser));
}

/**
 * Affiche un composant en fonction de son id
 * @param type $idComponent
 * @return type
 */
function ShowThisComponent($idComponent) {
    $dtb = connectDB();
    $sql = "SELECT * FROM t_composant WHERE id_composant = ? ";
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array($idComponent));
    $data = $maRequete->fetch(PDO::FETCH_ASSOC);
    return $data;
}

/**
 * Récupère le nom du composant grâce à on id
 * @param type $idComponent
 * @return type
 */
function GetNameById($idComponent) {
    $dtb = connectDB();
    $maRequete = $dtb->prepare('SELECT nom_categorie FROM t_categorie WHERE id_categorie = ?');
    $maRequete->execute(array($idComponent));
    $data = $maRequete->fetchColumn();
    return $data;
}

/**
 * Met à jour les informations du composant
 * @param type $currentComponent
 * @param type $newNameComponent
 * @param type $newDescriptionComponent
 * @param type $newPrixComponent
 * @param type $newCategorieComponent
 * @return type$
 */
function UpdateComponentInformation($currentComponent, $newNameComponent, $newDescriptionComponent, $newPrixComponent, $newCategorieComponent) {

    $dtb = connectDB();

    $sqlUpdate = ("UPDATE t_composant
                SET nom_composant=?, description_composant=?, prix_composant=?, id_categorie=?
                WHERE id_composant=?;");

    $maRequete = $dtb->prepare($sqlUpdate);
    $maRequete->execute(array($newNameComponent, $newDescriptionComponent, $newPrixComponent, $newCategorieComponent, $currentComponent));

    $sql = "SELECT * FROM t_composant WHERE id_composant = ?";
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array($currentComponent));
    $data = $maRequete->fetch(PDO::FETCH_ASSOC);
    return $data;
}

/**
 * Supprime un composant grâce à son id
 * @param type $idComponent
 */
function DeletComponentById($idComponent) {
    $dtb = connectDB();
    $MaRequete = $dtb->prepare('DELETE FROM t_composant WHERE id_composant=' . $idComponent . '');
    $MaRequete->execute(array());
}

/**
 * Permet de calculer le prix total de la configuration grâce au composant dans la session
 * @return type
 */
function CalculatePrice() {
    $dtb = connectDB();
    $sql = "Select nom_categorie from t_categorie where 1";
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array());
    while ($data = $maRequete->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $data;
    }
    $total = 0;
    foreach ($return as $value) {
        if (isset($_SESSION[$value["nom_categorie"]])) {
            if (empty($_SESSION[$value["nom_categorie"]]["nom_composant"])) {
                $prix = 0;
            } else {
                $prix = $_SESSION[$value["nom_categorie"]]["prix_composant"];
            }
            $total = $total + $prix;
        } else {
            
        }
    }

    return $total;
}

/**
 * Permet de vider la session qui comporte les composant
 */
function ClearSession() {
    $dtb = connectDB();
    $sql = "Select nom_categorie from t_categorie where 1";
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array());
    while ($data = $maRequete->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $data;
    }

    foreach ($return as $value) {
        if (isset($_SESSION[$value["nom_categorie"]])) {
            $_SESSION[$value["nom_categorie"]] = [];
        }

//        $_SESSION[$value["nom_categorie"]]["photo_composant"] = "images/composant/default.png";
//        $_SESSION[$value["nom_categorie"]]["prix_composant"] = 0;
//        $_SESSION[$value["nom_categorie"]]["nom_composant"] = "";
    }
}

/**
 * Ajout une nouvelle configuration dans la base de données
 * @staticvar type $maRequete
 * @param type $price
 * @param type $title
 * @param type $idUtilisateur
 * @return string
 */
function AddConfiguration($price, $title, $idUtilisateur) {
    static $maRequete = null;
    $error = "";

    $actif = true;
    //Prépaper la requête lors du premier appel
    if ($maRequete == null) {
        $maRequete = connectDB()->prepare("INSERT INTO t_configuration ( prix_configuration, titre_configuration, estActive, id_utilisateur)
                                                VALUES                 (                  ?,                   ?,         ?,              ?)");
    }

    try {
        //Enregistrer les données
        $maRequete->execute(array($price, $title, $actif, $idUtilisateur));
        AddComponentsToConfiguration($components, connectDB()->lastInsertId());
        $error = "OK";
    } catch (Exception $e) {
        $error = "error";
    }
    return $error;
}

/**
 * Ajout les composant la configuration grâce à une table de liaison
 * @param type $components
 * @param type $id
 */
function AddComponentsToConfiguration($components, $id) {
    $dtb = connectDB();
    $sql = "INSERT INTO t_composee (id_configuration, id_composant) VALUES (?, ?)";
    $maRequete = $dtb->prepare($sql);

    foreach ($components as $idCategorie) {

        $maRequete->execute(array($id, $idCategorie));
    }
}

/**
 * Affiches les configurations actives
 * @param type $idUser
 */
function ShowCreationActive($idUser) {
    $dtb = connectDB();
    $return = [];
    $sql = 'Select * from t_configuration where id_utilisateur = ' . $idUser . ' and estActive=1 ';
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute();
    while ($data = $maRequete->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $data;
    }
    if ($return == []) {
        echo'<h4>Mes créations actives</h4>';
        echo "<h5>Vous n'avez pas de création active !</h5>";
    } else {
        echo'<h4>Mes créations actives</h4>';
        echo '</br>';
        echo'<table class="table">';
        echo'<tr><th>Nom</th><th>Prix</th><th>Modification</th></tr>';
        foreach ($return as $value) {
            echo '<tr>';
            echo '<td><h4>' . $value['titre_configuration'] . ' </h4></td>';
            echo '<td><h4>' . $value['prix_configuration'] . '</h4></td>';
            echo '<td><a href="?idConfiguration=' . $value['id_configuration'] . '"><h4><span class="glyphicon glyphicon-cog"></span></h4></td></a>';
            echo '<tr>';
        }
        echo'</table>';
    }
}

/**
 * Affiches les configurations inactives
 * @param type $idUser
 */
function ShowCreationInactive($idUser) {
    $dtb = connectDB();
    $return = [];
    $sql = 'Select * from t_configuration where id_utilisateur = ' . $idUser . ' and estActive=0 ';
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute();
    while ($data = $maRequete->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $data;
    }
    if ($return == []) {
        echo'<h4>Mes créations inactives</h4>';
        echo "<h5>Vous n'avez pas de création inactive !</h5>";
    } else {
        echo'<h4>Mes créations inactives</h4>';
        echo'<table class="table">';
        echo '</br>';
        echo'<tr><th>Nom</th><th>Prix</th><th>Modification</th></tr>';
        foreach ($return as $value) {
            echo '<tr>';
            echo '<td><h4>' . $value['titre_configuration'] . ' </h4></td>';
            echo '<td><h4>' . $value['prix_configuration'] . '</h4></td>';
            echo '<td><a href="?idConfiguration=' . $value['id_configuration'] . '"><h4><span class="glyphicon glyphicon-cog"></span></h4></td></a>';
            echo '<tr>';
        }
        echo'</table>';
    }
}

/**
 * Affiches tous les composants de la configuration avec toutes les informations
 * @param type $idConfiguration
 */
function ShowComponentsById($idConfiguration) {
    $dtb = connectDB();
    $sql = "SELECT nom_composant, prix_composant, photo_composant, id_categorie FROM t_composant ca, t_composee ce WHERE ca.id_composant = ce.id_composant AND ce.id_configuration = ?";
    $maRequete = $dtb->prepare($sql);

    $maRequete->execute(array($idConfiguration));

    while ($data = $maRequete->fetch(PDO::FETCH_ASSOC)) {
        $chemin = '<img src="images/composant/' . GetNameById($data['id_categorie']) . '/' . $data['photo_composant'] . '" class="img-rounded" id="imgCenter"/>';
        echo $chemin;
        echo '<h4>' . $data['nom_composant'] . "</h4>";
        echo '<h4>' . $data['prix_composant'] . " CHF</h4>";
    }
}

/**
 * Récupère les données de la configuration
 * @param type $idConfiguration
 * @return type
 */
function GetConfiguration($idConfiguration) {
    $dtb = connectDB();
    $sql = 'SELECT * FROM t_configuration WHERE id_configuration = ?';
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array($idConfiguration));
    $data = $maRequete->fetch(PDO::FETCH_ASSOC);
    return $data;
}

/**
 * Met à jour quelques informations de la configuration
 * @param type $idConfiguration
 * @param type $title
 * @param type $Etat
 * @return type
 */
function UpdateConfiguration($idConfiguration, $title, $Etat) {
    $dtb = connectDB();
    $sqlUpdate = ("UPDATE t_configuration
                SET titre_configuration=?, estActive=?
                WHERE id_configuration=?;");

    $maRequete = $dtb->prepare($sqlUpdate);
    $maRequete->execute(array($title, $Etat, $idConfiguration));

    $sql = 'SELECT * FROM t_configuration WHERE id_configuration = ?';
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array($idConfiguration));
    $data = $maRequete->fetch(PDO::FETCH_ASSOC);
    return $data;
}
