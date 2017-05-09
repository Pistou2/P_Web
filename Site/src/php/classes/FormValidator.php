<?php

    /*
        ETML
        Auteur: Yann Merk
        Date: 07.03.17
        Description: Class pour la validation de donnée des formulaires
     */

    class FormValidator
    {


        /**
         * Vérifie si le email et le mot de passe rentré sont correct
         * @param string $email Email rentré
         * @param string $password mot de passe rentré
         * @return int Si la connexion a réussi, retourne l'id de l'utilisateur sinon null
         */
        public static function checkLogin(string $email, string $password)
        {
            // Obtient les informations pour l'utilisateur avec l'email rentrer
            $userData = DBCom::getUserData($email);

            // S'il y a un utilisateur avec cette email
            if (!empty($userData)) {
                // Vérifie si le mot de passe est correct
                if (password_verify($password, $userData[0]["usePassword"])) ;
                {
                    // Retourne l'id de l'utilisateur
                    return $userData[0]["idUser"];
                }
            }

            // Retourne null
            return null;
        }

        /**
         * Vérifie si les données rentrée pour l'inscription sont correct
         * @param string $email Email rentré
         * @param string $password Mot de passe rentré
         * @param string $passwordConfirmed Mot de passe de vérification
         * @return string Message d'erreur, null s'il n'y en a pas
         */
        public static function checkRegister(string $email, string $password, string $passwordConfirmed)
        {
            // Regex pour la vérification de l'email et du mot de passe
            $regEmail = '/^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i'; // Pris depuis https://regex101.com/library/mN1eF6
            $regPassword = '/^.{8,}$/';

            // Vérifie que l'email correspond au regex
            if (preg_match($regEmail, $email)) {

                // Vérifie que les deux mot de passe soit les même
                if ($password === $passwordConfirmed) {

                    // Vérifie que le mot de passe correspond au regex
                    if (preg_match($regPassword, $password)) {

                        // Vérifie qu'il n'y a pas déjà un utilisateur pour l'email
                        if (!DBCom::getUserData($_POST["email"])) {
                            // Retourne null
                            return null;
                        } else {
                            return "Votre adresse email est déjà utilisée";
                        }
                    } else {
                        return "Le mot de passe doit être de plus de 8 caractères";
                    }
                } else {
                    return "Les deux mots de passe indiquer ne correspondent pas";
                }
            } else {
                return "L'email n'est pas valide";
            }
        }


        /**
         * Vérifie qu'un livre a ajouté est correct
         * @param array $postResult Tableau contenant tous les valeurs passées en POST
         * @param array $fileResult Tableau contenant toutes les informations sur les fichiers passé
         * @return int Index du livre ajouté
         */
        public static function checkAddBook(array $postResult, array $fileResult)
        {
            $isCorrect = true;

            // Vérifie que le nom du livre est set et non vide
            if (empty($postResult["bookName"])) {
                $isCorrect = false;

                // Ecrit une erreur
                Misc::writeMessage(3, "<strong>Erreur !</strong> Nom de livre incorrect.");
            }

            // Vérifier que le nom et prénom de l'auteur est set et non vide
            if (empty($postResult["authorName"]) || empty($postResult["authorFirstname"])) {
                $isCorrect = false;

                // Ecrit une erreur
                Misc::writeMessage(3, "<strong>Erreur !</strong> Nom ou Prénom de l'auteur incorrect.");
            }

            // Vérifie que l'éditeur est set et non vide
            if (empty($postResult["editor"])) {
                $isCorrect = false;

                // Ecrit une erreur
                Misc::writeMessage(3, "<strong>Erreur !</strong> Éditeur incorrect.");
            }

            // Vérifie qu'au moins une catégorie de livre est sélectionnée
            if (empty($postResult['bookCategory']) || count($postResult['bookCategory']) == 0) {
                $isCorrect = false;

                // Ecrit une erreur
                Misc::writeMessage(3, "<strong>Erreur !</strong> Prière de choisir au moins une catégorie de livre.");
            }

            // Vérifie que le type de livre est set et non vide
            if (empty($postResult["selType"])) {
                $isCorrect = false;

                // Ecrit une erreur
                Misc::writeMessage(3, "<strong>Erreur !</strong> Prière de choisir un type de livre correct.");
            }

            // Vérifie que le nombre de page est set et non vide
            if (empty($postResult["nbPage"])) {
                $isCorrect = false;

                // Ecrit une erreur
                Misc::writeMessage(3, "<strong>Erreur !</strong> Prière de rentrer un nombre de page.");
            }

            // Vérifie que l'année de parution est set et est un integer
            if (empty($postResult["releaseYear"]) || !ctype_digit($postResult["releaseYear"])) {
                $isCorrect = false;

                // Ecrit une erreur
                Misc::writeMessage(3, "<strong>Erreur !</strong> Prière de rentrer une année de parution correcte.");
            }

            // Vérifier que l'image de couverture a bien été envoyée
            if ($fileResult['bookPicture']['error'] != 0) {
                $isCorrect = false;

                // Ecrit une erreur
                Misc::writeMessage(3, "<strong>Erreur !</strong> Une image de couverture doit être incluse.");
            } // Vérifier que l'image de couverture est correct
            else if (explode("/", $fileResult['bookPicture']['type'])[0] != "image") {
                $isCorrect = false;

                // Ecrit une erreur
                Misc::writeMessage(3, "<strong>Erreur !</strong> L'image de couverture soumise n'est pas valide / Une erreur est survenue lors de l'envoi.");
            }

            // Vérifier que si un extrait est envoyé, il est valide
            if ($fileResult['bookExtract']['error'] != 4 && ($fileResult['bookExtract']['error'] != 0 || $fileResult['bookExtract']['type'] != "application/pdf")) {
                $isCorrect = false;

                //Ecrit une erreur
                Misc::writeMessage(3, "<strong>Erreur !</strong> Le format de l'extrait soumis n'est pas valide / Une erreur est survenue lors de l'envoi.<br>(Seuls les PDF sont autorisés)");
            }

            // Si tout est correct
            if ($isCorrect) {

                // Déplace le fichier temporaire de la couverture
                $extensionFile = end(explode(".", $fileResult['bookPicture']['name']));
                $destinDirectory = "../../userContent/Book_Cover/";
                $destinName = strval(date("Y-m-d-h-i-s", time())) . "." . $extensionFile;

                move_uploaded_file($fileResult['bookPicture']['tmp_name'], $destinDirectory . $destinName);

                $postResult['bookPicture'] = $destinName;

                //Déplace le fichier temporaire d l'extrait, si il existe
                if (isset($fileResult['bookExtract'])) {
                    $extensionFile = end(explode(".", $fileResult['bookExtract']['name']));
                    $destinDirectory = "../../userContent/Book_Extract/";
                    $destinName = strval(date("Y-m-d-h-i-s", time())) . "." . $extensionFile;

                    move_uploaded_file($fileResult['bookExtract']['tmp_name'], $destinDirectory . $destinName);

                    $postResult['bookExtract'] = $destinName;
                }

                // Récupère l'id de l'auteur
                $answer = DBCom::getAuthor($postResult['authorName'], $postResult['authorFirstname']);

                $postResult['idAuthor'] = $answer[0];

                // Récupère l'id de l'éditeur
                $answer = DBCom::getEditor($postResult['editor']);

                $postResult['idEditor'] = $answer[0];


                // Set l'utilisateur
                $postResult["idUser"] = $_SESSION["userID"];


                return DBCom::addBook($postResult);
            }

            return null;
        }
    }
