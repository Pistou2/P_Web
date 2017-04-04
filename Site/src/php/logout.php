<?php
//Reset la session et redirige vers la page d'accueil
    session_start();
    $_SESSION = Array();
    $_SESSION["mustShowPopup"] = true;

    header("location: Accueil");
