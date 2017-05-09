<!DOCTYPE html>
<!--
    Auteurs: Clément Dieperink + Yann Merk
    Date: 14.02.2017
    Description: Début de toutes les pages du site
-->

<?php
    session_start();

    // Pour inclure automatiquement les classes
    spl_autoload_register(function ($class) {
        include_once "classes/$class.php";
    });

    // S'il n'y a pas de changement de titre pour la page
    if (!isset($pageTitle)) {

        // Obtient le titre par défaut pour la page
        $pageTitle = GlobalValue::PAGES_ARRAY["$pageId"][0];
    }

    // Si la variable userID de la session n'est pas enregistrée la met à null
    if (!isset($_SESSION["userID"])) {
        $_SESSION["userID"] = null;
    }

    // Si la variable mustShowPopup de la session n'est pas enregistrée la met à false
    if (!isset($_SESSION["mustShowPopup"])) {
        $_SESSION["mustShowPopup"] = false;
    }

    // Vérifie si l'utilisateur est connecté
    $isConnected = $_SESSION["userID"] != null;

    /*Liste de page :
    0 : Accueil
    1 : Ouvrage
    2 : AddBook
    3 : 401Error
    4 : 404Error
    5 : Login
    6 : Inscription
    7 : ShowBook
    */
?>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo $pageTitle . " - " . GlobalValue::SITE_TITLE ?></title>

        <!-- Bootstrap -->
        <link type="text/css" href="/resources/lib/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="/resources/css/common.css" rel="stylesheet">
        <link href="/resources/image/book-256.ico" rel="icon">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="head">
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="Accueil"><?php echo GlobalValue::SITE_TITLE ?></a>
                    </div>

                    <ul class="nav navbar-nav">
                        <li <?php echo $pageId === 0 ? 'class="active"' : '' ?>><a
                                href=<?php echo '"' . GlobalValue::PAGES_ARRAY[0][0] . '">' . GlobalValue::PAGES_ARRAY[0][0] ?></a>
                        </li>
                        <li <?php echo $pageId === 1 ? 'class="active"' : '' ?>><a
                                href=<?php echo '"' . GlobalValue::PAGES_ARRAY[1][1] . '">' . GlobalValue::PAGES_ARRAY[1][0] ?></a>
                        </li>

                        <?php
                            if ($isConnected) {
                                echo '<li' . ($pageId === 2 ? ' class="active"' : '') . '><a href="' . GlobalValue::PAGES_ARRAY[2][1] . '">' . GlobalValue::PAGES_ARRAY[2][0] . '</a></li>';
                            }
                        ?>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <?php
                            // Si l'utilisateur est connecté affiche le bouton de déconnexion
                            if ($isConnected) {
                                ?>
                                <li><a href="logout?previousPageID=<?php echo $pageId ?>"><span
                                            class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>
                                <?php
                            } else {
                                // Sinon affiche le lien pour la connexion et l'inscription
                                ?>
                                <li><a href="Inscription?previousPageID=<?php echo $pageId ?>"><span
                                            class="glyphicon glyphicon-user"></span> Inscription</a></li>
                                <li><a href="login?previousPageID=<?php echo $pageId ?>"><span
                                            class="glyphicon glyphicon-log-in"></span> Connexion</a></li>
                                <?php
                            }
                        ?>
                    </ul>
                </div>
            </nav>
            <div class="jumbotron text-center">
                <h1><?php echo $pageTitle ?></h1>
            </div>
        </div>
        <div id="container">
            <div class="row">
                <div class="col-sm-8 col-sm-push-2">

                    <?php
                        // S'il faut afficher un popup pour la confirmation de connexion/déconnexion
                        if ($_SESSION["mustShowPopup"]) {
                        // Si l'utilisateur est connecté affiche que la connexion a été réussie
                        if ($isConnected) {
                        ?>
                        <div class="alert alert-success alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Connection réussie!</strong>
                        </div>
                        <?php
                    } else {
                        // Sinon affiche que la déconnexion est réussie
                    ?>
                    <div class="alert alert-success alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <strong>Vous vous êtes bien déconnecté.</strong>
                    </div>
<?php
    }

    // Indique qu'il ne faut plus afficher le popup
    $_SESSION["mustShowPopup"] = false;
    }
?>