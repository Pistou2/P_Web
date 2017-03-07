<!DOCTYPE html>

<!--
ETML
Auteur: Clément Dieperink
Date: 14.02.2017
Description:
-->

<?php
    session_start();

    if (!isset($_SESSION["isConnected"])){
        $_SESSION["isConnected"] = false;
    }

    if (!isset($_SESSION["mustShowPopup"])){
        $_SESSION["mustShowPopup"] = false;
    }

    // Pour inclure automatiquement les classes
    spl_autoload_register(function ($class) {
        include_once "classes/$class.php";
    });

    $isConnected = $_SESSION["isConnected"];

    /*Liste de page :
    0 : Accueil
    1 : Ouvrage
    2 : AddBook
    3 : 401Error
    4 : 404Error
    5 : Login
    */
?>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo GlobalValue::PAGES_ARRAY[$pageId]." - ".GlobalValue::SITE_TITLE ?></title>

        <!-- Bootstrap -->
        <link type="text/css" href="resources/lib/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
        <link type="text/css" href="resources/css/common.css" rel="stylesheet">
        <link href="resources/image/book-256.ico" rel="icon">

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
                        <a class="navbar-brand" href="/"><?php echo GlobalValue::SITE_TITLE ?></a>
                    </div>

                    <ul class="nav navbar-nav">
                        <li <?php echo $pageId === 0 ? 'class="active"' : '' ?>><a href=<?php echo '"'.GlobalValue::PAGES_ARRAY[0][0].'">'.GlobalValue::PAGES_ARRAY[0][0] ?></a></li>
                        <li <?php echo $pageId === 1 ? 'class="active"' : '' ?>><a href=<?php echo '"'.GlobalValue::PAGES_ARRAY[1][1].'">'.GlobalValue::PAGES_ARRAY[1][0] ?></a></li>

                        <?php
                            if ($isConnected) {
                                echo '<li' . ($pageId === 2 ? ' class="active"' : '') . '><a href="'.GlobalValue::PAGES_ARRAY[2][1].'">'.GlobalValue::PAGES_ARRAY[2][0].'</a></li>';
                            }
                        ?>
                    </ul>

                    <ul class="nav navbar-nav navbar-right">
                        <?php
                            if ($isConnected) {
                                echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> Mon Compte</a></li>';
                                echo '<li><a href="#"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>';
                            } else {
                                echo '<li><a href="#"><span class="glyphicon glyphicon-user"></span> Inscription</a></li>';
                                echo '<li><a href="/login?previousPageID='.$pageId.'"><span class="glyphicon glyphicon-log-in"></span> Connexion</a></li>';
                            }
                        ?>
                    </ul>
                </div>
            </nav>
            <div class="jumbotron text-center">
                <h1><?php echo GlobalValue::PAGES_ARRAY[$pageId][0] ?></h1>
            </div>
        </div>
        <?php
            if ($_SESSION["mustShowPopup"]){
                if ($_SESSION["isConnected"]){
                    echo '<div class="modal fade" tabindex="-1" role="dialog" id="ConfirmConnection">';
                    echo '    <div class="modal-dialog" role="document">';
                    echo '        <div class="modal-content">';
                    echo '            <div class="modal-header">';
                    echo '                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    echo '                <h4 class="modal-title">Connexion réussie</h4>';
                    echo '            </div>';
                    echo '            <div class="modal-body">';
                    echo '                <p>Vous avez bien été déconnecté de votre compte&hellip;</p>';
                    echo '            </div>';
                    echo '            <div class="modal-footer">';
                    echo '                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>';
                    echo '            </div>';
                    echo '        </div><!-- /.modal-content -->';
                    echo '    </div><!-- /.modal-dialog -->';
                    echo '</div><!-- /.modal -->';
                }

                else{

                }
            }
        ?>
        <div id="container">
