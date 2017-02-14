<!DOCTYPE html>

<!--
ETML
Auteur: Clément Dieperink
Date: 14.02.2017
Description:
-->

<?php
    // Pour inclure automatiquement les classes
    spl_autoload_register(function ($class) {
        include_once "classes/$class.php";
    })
?>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo GlobalValue::SITE_TITLE #TODO FAIRE EN SORTE QUE YANN FERME SA BOUCHE?></title>

        <!-- Bootstrap -->
        <link href="../../resources/lib/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/"><?php echo GlobalValue::SITE_TITLE?></a>
                </div>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/index.php">Accueil</a></li>
                    <li><a href="/books.php">Ouvrages</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#"><span class="glyphicon glyphicon-user"></span> Inscription</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Connexion</a></li>
                </ul>
            </div>
        </nav>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="../../resources/lib/jquery-3.1.1.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../../resources/lib/bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    </body>
</html>