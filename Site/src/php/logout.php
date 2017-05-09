<?php
    /*
        ETML
        Auteur: Yann Merk
        Date: 14.03.17
        Description: Permet � une personne de se d�connecter
    */

    // Ouvre la session
    session_start();

    // Pour inclure automatiquement les classes
    spl_autoload_register(function ($class) {
        include_once "classes/$class.php";
    });

    // R�initialise la session et indique qu'il faut afficher un popup (pour confirmer la d�connexion)
    $_SESSION = Array();
    $_SESSION["mustShowPopup"] = true;

    // Redirige vers la page pr�c�dente, ou la page d'accueil si aucune est entr�e
    if (isset($_GET["previousPageID"])) {
        header("location: " . GlobalValue::PAGES_ARRAY[$_GET["previousPageID"]][1]);
    } else {
        header("location: Accueil");
    }
