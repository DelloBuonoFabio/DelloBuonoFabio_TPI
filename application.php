<?php

/**
 * Allows connection to the DB
 * @staticvar type $maDB
 * @return  DB
 */
function ConnectDB() {
    static $maDB = null;
    try {
        if ($maDB == null) {
            $maDB = new PDO("mysql:host=localhost;dbname=hardware;charset=utf8", 'admin', // username 
                    'Super', // mdp 
                    array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false));
        }
    } catch (Exception $e) {
        die("R.I.P in peace " . $e->getMessage());
    }
    return $maDB;
}

function menu() {
    $PageName = basename($_SERVER["PHP_SELF"]);

    if (empty($_SESSION['user_logged'])) {
        //if the user is not connected
        $menu = array("index.php" => 'Home <span class="glyphicon glyphicon-home"></span>',
            "login.php" => 'Login <span class="glyphicon glyphicon-user"></span>',
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
                <a class="navbar-brand" href="index.php">ExBootStrap</a>
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
        $error = "";
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
    ;
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
        echo '<tr>';
        echo '<td>' . $value["nom_categorie"] . '<p class="pull-right"><a href="components.php?Categorie=' . $value["nom_categorie"] . '"><span class="glyphicon glyphicon-tag"></span></a></p>' . '</td>';

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
        echo '<img src="images/img_configuration/Img' . $tempo .'.gif" alt="..." class="img-thumbnail">';

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
        echo '<th>' . $value["id_utilisateur"] . '</th>';
        echo '<td>' . $value["nom_utilisateur"] . '</td>';
        echo '<td>' . $value["prenom_utilisateur"] . '</td>';
        echo '<td>' . $value["email_utilisateur"] . '</td>';
        echo '<td>' . $value["estAdmin"] . '</td>';
        echo '<td><a href="#" ><span class="glyphicon glyphicon-trash"></span></a></td>';
        echo '<td><a href="#" ><span class="glyphicon glyphicon-pencil"></span></a></td>';
        echo '</tr>';
    }
}