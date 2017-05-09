<?php

    /*
    *  ETML
    *  Auteur : Clément Dieperink
    *  Date : 14.02.2017
    *  Description : Class avec des variables/constant globals à tout le site
    */


    class GlobalValue
    {
        // Nom du site
        const SITE_TITLE = "Share Book";

        // Pages du site
        // Premier tableau index de la page
        // Second tableau 0 = Titre de la page, 1 = Nom du fichier de la page
        const PAGES_ARRAY =
            [
                ["Accueil", "Accueil"],
                ["Ouvrages", "Ouvrage"],
                ["Ajouter un ouvrage", "AddBook"],
                ["Erreur 401", "401Error"],
                ["Erreur 404", "404Error"],
                ["Login", "Login"],
                ["Inscription", "Inscription"],
                ["Livre", "ShowBook"]
            ];

        // Id de la page d'inscription
        const ID_PAGE_INSCRIPTION = 6;
    }