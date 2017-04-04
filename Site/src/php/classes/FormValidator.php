<?php

    /**ETML
     *\author  merkya
     *\date    07.03.2017
     *\summary
     */
    class FormValidator
    {


        /**Check if the email and the password inputed are correct
         * TODO : Implement that with the Database
         * for now it only ready the login from a login.txt file
         * 1 ID + login + password per line, everything separated by a \t
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


        //TODO
        public static function checkAddBook(array $postResult)
        {
            $isCorrect = true;

            //Vérifie que le nom du livre est set et non vide
            if (!empty($postResult["bookName"])) {
                $isCorrect = false;
                //Write an error
                Misc::writeMessage(3, "<strong>Erreur !</strong> Nom de livre incorrect.");
            }

            //Vérifier que le nom et prénom de l'auteur est set et non vide
            //TODO : Vérifier si il n'existe pas déjà ???
            if (!empty($postResult["authorName"]) && !empty($postResult["authorFirstname"])) {
                $isCorrect = false;
                //Write an error
                Misc::writeMessage(3, "<strong>Erreur !</strong> Nom ou Prénom de l'auteur incorrect.");
            }

            //Vérifie que l'éditeur est set et non vide
            //TODO : Vérifier si il n'existe pas déjà ???
            if (!empty($postResult["editor"])) {
                $isCorrect = false;
                //Write an error
                Misc::writeMessage(3, "<strong>Erreur !</strong> Éditeur incorrect.");
            }

            //Vérifie que le type de livre est set et non vide
            //TODO : Vérifier si il n'existe pas déjà ???
            if (!empty($postResult["selType"])) {
                $isCorrect = false;
                //Write an error
                Misc::writeMessage(3, "<strong>Erreur !</strong> Prière de choisir un type de livre correct");
            }

            return $isCorrect;
        }
    }
