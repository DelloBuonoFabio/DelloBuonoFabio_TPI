<?php

/**
 * Allows connection to the DB
 * @staticvar type $maDB
 * @return  DB
 */
function ConnectDB() {
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

function menu() {
    $PageName = basename($_SERVER["PHP_SELF"]);

    if (empty($_SESSION['user_logged'])) {
        //if the user is not connected
        $menu = array("index.php" => 'Accueil <span class="glyphicon glyphicon-home"></span>',
            "connexion.php" => 'Connexion <span class="glyphicon glyphicon-user"></span>',
            "hardware.php" => 'HardWare <span class="glyphicon glyphicon-wrench"></span>'
        );
    } else {
        //if the user is connected 
        if ($_SESSION['user_logged']['estAdmin']) {
            $menu = array("index.php" => 'Home <span class="glyphicon glyphicon-home"></span>',
                "hardware.php" => 'HardWare <span class="glyphicon glyphicon-wrench"></span>',
                "configuration.php" => 'Configuration <span class="glyphicon glyphicon-cog"></span>',
                "AdminUtilisateur.php" => 'Admin. Utilisateur <span class="glyphicon glyphicon-user"></span>',
                "AdminComposants.php" => 'Admin. Composants <span class="glyphicon glyphicon-tags"></span>',
                "logout.php" => 'Logout <span class="glyphicon glyphicon-remove"></span>'
            );
        } else {
            $menu = array("index.php" => 'Home <span class="glyphicon glyphicon-home"></span>',
                "hardware.php" => 'HardWare <span class="glyphicon glyphicon-wrench"></span>',
                "configuration.php" => 'Configuration <span class="glyphicon glyphicon-cog"></span>',
                "compte.php" => 'Mon Compte <span class="glyphicon glyphicon-user"></span>',
                "logout.php" => 'Logout <span class="glyphicon glyphicon-remove"></span>'
            );
        }
    }
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

function AllFooter() {
    $localFooter = '
        <p class="pull-right"><a href=""><span class="glyphicon glyphicon-eject"></span></a></p>
        <p>Dello Buono Fabio</p>';
    return $localFooter;
}

/**
 * Add a new user in the DB 
 * @staticvar type $maRequete
 * @param type $name
 * @param type $password
 * @return string if the user name is already assigned 
 */
function AddUser($name, $firstname, $email, $password) {
    static $maRequete = null;
    $error = "";
    $admin = false;
    $newMDP = sha1($password);

    //Prépaper la requête lors du premier appel
    if ($maRequete == null) {
        $maRequete = ConnectDB()->prepare("INSERT INTO t_utilisateur (nom_utilisateur, prenom_utilisateur, email_utilisateur, motDePasse_utilisateur, estAdmin)
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
 * check if the user is in the DB
 * @param string $email
 * @param string $password
 */
function CheckLogin($email, $password) {
    $dtb = ConnectDB();
    $password = sha1($password);
    $sql = "SELECT * FROM t_utilisateur WHERE email_utilisateur = ? AND motDePasse_utilisateur = ? ";
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array($email, $password));
    $data = $maRequete->fetch(PDO::FETCH_ASSOC);
    return $data;
    // return data user
}

function ShowCategorie() {
    $dtb = ConnectDB();
    $sql = "Select nom_categorie from t_categorie where 1";
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array());
    while ($data = $maRequete->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $data;
    }

    echo '<table class="table">';
    foreach ($return as $value) {
        echo '<tr class="listeCategorie">';
        echo '<td>' . $value["nom_categorie"] . '<p class="pull-right"><a href="components.php?categorie=' . $value["nom_categorie"] . '"><span class="glyphicon glyphicon-tag"></span></a></p></td>';

        echo '</tr>';
    }
    echo '</table>';
}

function ShowThisCategorie($categorieName) {
    $dtb = ConnectDB();
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

function ShowConfiguration() {
    $dtb = ConnectDB();
    $sql = "Select nom_categorie from t_categorie where 1";
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array());
    while ($data = $maRequete->fetch(PDO::FETCH_ASSOC)) {
        $return[] = $data;
    }
    $tempo = 0;

    foreach ($return as $value) {
        $tempo ++;
        echo '<div class="panel panel-default panel-dropdown">
                <div class="panel-heading">
                    <h2 class="panel-title">';

        echo $value["nom_categorie"];
        echo '<span class="pull-right glyphicon glyphicon-triangle-top"></span>
                    </h2>
                </div>
                <!-- Contenue de la liste -->
                <div class="panel-body" class="texte-configuration">';
        echo '<img src="images/img_configuration/Img' . $tempo . '.gif" alt="..." class="img-thumbnail">';

        echo '<a href="components.php?Categorie=' . $value["nom_categorie"] . '"><h4>Veuillez choisir un/e ' . $value["nom_categorie"] . '</h4></a>
                </div>
            </div>';
    }
}

function ShowUser() {
    $dtb = ConnectDB();
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

function DeletUser($EmailUser) {
    $dtb = connectDB();
    $MaRequete = $dtb->prepare("DELETE FROM t_utilisateur WHERE email_utilisateur=?");
    $MaRequete->execute(array($EmailUser));
}

function GetCategorrie() {
    $dtb = ConnectDB();
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

function ShowComponent($categorieName) {
    $dtb = ConnectDB();
    $location = "./images/composant/";
    if ($categorieName == "ca.nom_categorie") {
        $tempo = "";
    } else {
        $tempo = '"';
    }
    $sql = 'SELECT `id_composant`,`nom_composant`, `photo_composant`, `prix_composant`, `nom_categorie` FROM t_composant co,t_categorie ca where ca.id_categorie = co.id_categorie and ca.nom_categorie = '. $tempo . $categorieName . $tempo . ' ';
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

function AddComponent($nameComponent, $descrptionComponent, $imgComponent, $priceComponent, $categorieComponent){
    static $maRequete = null;
    $error = "";

    //Prépaper la requête lors du premier appel
    if ($maRequete == null) {
        $maRequete = ConnectDB()->prepare("INSERT INTO t_composant (nom_composant, prenom_composant, photo_composant, prix_composant, id_categorie)
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

function GetIdByName($categorieComponent){
    $dtb = ConnectDB();
    $maRequete = $dtb->prepare('SELECT id_categorie FROM t_categorie WHERE nom_categorie = "?"');
    $maRequete->execute(array($categorieComponent));
    $data = $maRequete->fetchColumn();
    return $data;
}

function DeletUserById($idUser){
    $dtb = connectDB();
    $MaRequete = $dtb->prepare('DELETE FROM t_utilisateur WHERE id_utilisateur=?');
    $MaRequete->execute(array($idUser));
}

function ShowThisComponent($idComponent) {
    $dtb = ConnectDB();
    $sql = "SELECT * FROM t_composant WHERE id_composant = ? ";
    $maRequete = $dtb->prepare($sql);
    $maRequete->execute(array($idComponent));
    $data = $maRequete->fetch(PDO::FETCH_ASSOC);
    return $data;
}

function GetNameById($idComponent){
    $dtb = ConnectDB();
    $maRequete = $dtb->prepare('SELECT nom_categorie FROM t_categorie WHERE id_categorie = ?');
    $maRequete->execute(array($idComponent));
    $data = $maRequete->fetchColumn();
    return $data;
}