<?php

    /**ETML
     *\author  merkya
     *\date    07.03.2017
     *\summary
     */
    class FormValidator
    {


        /**Check if the email and the password inputed are correct
         * @param string $email
         * @param string $password
         * @return int If the login is successfull, return the user ID, else, null
         */
        public static function checkLogin(string $email, string $password)
        {
            $userData = DBCom::getUserData($email);

            if ($userData) {
                if (password_verify($password, $userData[0]["usePassword"])) ;
                {
                    return $userData[0]["idUser"];
                }
            }

            return null;
        }

        public static function checkRegister($email, $password, $passwordComfirmed)
        {
            $regEmail = '/^\b[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i'; // Pris depuis https://regex101.com/library/mN1eF6
            $regPassword = '/^.{8,}$/';

            if (preg_match($regEmail, $email)) {
                if ($password === $passwordComfirmed) {
                    if (preg_match($regPassword, $password)) {
                        if (!DBCom::getUserData($_POST["email"])) {
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


        //TODO Gérer les images
        //TODO gérer description vide
        //TODO gérer auteur
        //todo gérer éditeur
        public static function checkAddBook(array $postResult, array $fileResult)
        {
            $isCorrect = true;

            //TODO
            echo "<pre>";
            print_r($postResult);
            print_r($fileResult);
            echo "</pre>";

            //Vérifie que le nom du livre est set et non vide
            if (empty($postResult["bookName"])) {
                $isCorrect = false;
                //Write an error
                Misc::writeMessage(3, "<strong>Erreur !</strong> Nom de livre incorrect.");
            }

            //Vérifier que le nom et prénom de l'auteur est set et non vide
            //TODO : Vérifier si il n'existe pas déjà ???
            if (empty($postResult["authorName"]) || empty($postResult["authorFirstname"])) {
                $isCorrect = false;
                //Write an error
                Misc::writeMessage(3, "<strong>Erreur !</strong> Nom ou Prénom de l'auteur incorrect.");
            }

            //Vérifie que l'éditeur est set et non vide
            //TODO : Vérifier si il n'existe pas déjà ???
            if (empty($postResult["editor"])) {
                $isCorrect = false;
                //Write an error
                Misc::writeMessage(3, "<strong>Erreur !</strong> Éditeur incorrect.");
            }

            //Vérifie qu'au moins une catégorie de livre est sélectionnée
            if (empty($postResult['bookCategory']) || count($postResult['bookCategory']) == 0) {
                $isCorrect = false;
                //Write an error
                Misc::writeMessage(3, "<strong>Erreur !</strong> Prière de choisir au moins une catégorie de livre.");
            }

            //Vérifie que le type de livre est set et non vide
            //TODO : Vérifier si il n'existe pas déjà ???
            if (empty($postResult["selType"])) {
                $isCorrect = false;
                //Write an error
                Misc::writeMessage(3, "<strong>Erreur !</strong> Prière de choisir un type de livre correct.");
            }

            //Vérifie que le nombre de page est set et non vide
            if (empty($postResult["nbPage"])) {
                $isCorrect = false;
                //Write an error
                Misc::writeMessage(3, "<strong>Erreur !</strong> Prière de rentrer un nombre de page.");
            }

            //Vérifie que l'année de parution est set et est un integer
            if (empty($postResult["releaseYear"]) || !ctype_digit($postResult["releaseYear"])) {
                $isCorrect = false;
                //Write an error
                Misc::writeMessage(3, "<strong>Erreur !</strong> Prière de rentrer une année de parution correcte.");
            }

            //vérifier que l'image de couverture a bien été envoyée
            if ($fileResult['bookPicture']['error'] != 0) {
                $isCorrect = false;
                //Ecrit une erreur
                Misc::writeMessage(3, "<strong>Erreur !</strong> Une image de couverture doit être incluse.");
            }          //vérifier que l'image de couverture est correct
            elseif (explode("/", $fileResult['bookPicture']['type'])[0] != "image") {
                $isCorrect = false;
                //Write an error
                Misc::writeMessage(3, "<strong>Erreur !</strong> L'image de couverture soumise n'est pas valide / Une erreur est survenue lors de l'envoi.");
            }

            //vérifier que si un extrait est envoyé, il est valide
            if ($fileResult['bookExtract']['error'] != 4 && ($fileResult['bookExtract']['error'] != 0 || $fileResult['bookExtract']['type'] != "application/pdf")) {
                $isCorrect = false;
                //Ecrit une erreur
                Misc::writeMessage(3, "<strong>Erreur !</strong> Le format de l'extrait soumis n'est pas valide / Une erreur est survenue lors de l'envoi.<br>(Seuls les PDF sont autorisés)");
            }
            //si tout est correct
            if ($isCorrect) {

                //upload la couverture
                $extensionFile = end(explode(".", $fileResult['bookPicture']['name']));
                $destinDirectory = "../../userContent/Book_Cover/";
                $destinName = strval(date("Y-m-d-h-i-s", time())) . "." . $extensionFile;

                move_uploaded_file($fileResult['bookPicture']['tmp_name'], $destinDirectory . $destinName);

                $postResult['bookPicture'] = $destinName;

                //upload l'extrait, si il existe
                if (isset($fileResult['bookExtract'])) {
                    $extensionFile = end(explode(".", $fileResult['bookExtract']['name']));
                    $destinDirectory = "../../userContent/Book_Extract/";
                    $destinName = strval(date("Y-m-d-h-i-s", time())) . "." . $extensionFile;

                    move_uploaded_file($fileResult['bookExtract']['tmp_name'], $destinDirectory . $destinName);

                    $postResult['bookExtract'] = $destinName;
                }

                //Todo Message d'avertissement en cas de nouvel auteur / éditeur
                //Récupère l'id de l'auteur
                $answer = DBCom::getAuthor($postResult['authorName'], $postResult['authorFirstname']);

                $postResult['idAuthor'] = $answer[0];

                //Récupère l'id de l'éditeur
                $answer = DBCom::getEditor($postResult['editor']);

                $postResult['idEditor'] = $answer[0];


                //Set l'utilisateur
                $postResult["idUser"] = $_SESSION["userID"];


                DBCom::addBook($postResult);
            }

            return $isCorrect;
        }
    }
