<?php

    /*
    *  ETML
    *  Auteur : Clément Dieperink
    *  Date : 21.03.17
    *  Description : Class pour la communication avec la base de donnée
    */

    class DBCom
    {
        // Information de connecion à la base de donnée
        private static $dbConParam = 'mysql:host=localhost;dbname=db_p_web';
        private static $dbUsername = 'root';
        private static $dbPassword = '.Etml-44';

        /**
         * Enregistre les données d'un nouvel utilisateur
         * @param string $email Email du nouvel utilisateur
         * @param string $hashedPassword Mot de passe hashé du nouvel utilisateur
         * @param string $registeryDate date d'enregistrement de l'utilisateur
         * @return string id de l'utilisateur
         */
        public static function saveUserData(string $email, string $hashedPassword, string $registeryDate)
        {
            // Enregistre les valeurs dans un tableau à deux dimension pour la génération de la commande
            $values = ["useNickname" => $email, "usePassword" => $hashedPassword, "useRegisteryDate" => $registeryDate];

            // Enregistre les données et retourne l'id de l'utilisateur
            return self::saveData("t_user", $values);
        }

        /**
         * Enregistre les données en paramètre
         * @param string $table Nom de la table où il faut enregistrer les données
         * @param array $rowValues Tableau avec les données à inserer (clé = nom de la colonne et valeur = valeur correspondante)
         * @return int id de la valeur inséré, 0 s'aucune valeur n'a été insérée
         */
        private static function saveData(string $table, array $rowValues)
        {
            // Se connecte à la BD
            $dbConnection = self::createConnexion();

            // Initialise un tableau avec les valeurs pour l'execution de la commande
            $values = [];
            foreach ($rowValues as $key => $value) {
                $values[":$key"] = $value;
            }

            // Crée la commande avec des variables SQL
            $sql = "INSERT INTO " . $table . " (" . implode(", ", array_keys($rowValues)) . ") VALUES (:" . implode(", :", array_keys($rowValues)) . ");";

            // Execute la commande, coupe la connexion et retourne l'id inséré
            if ($dbConnection->prepare($sql)->execute($values)) {
                $lastId = $dbConnection->lastInsertId();
                unset($dbConnection);
                return $lastId;
            } else {
                unset($dbConnection);
                return 0;
            }
        }

        /**
         * Crée une connexion à la BD
         * @return PDO la connexion à la BD
         */
        private static function createConnexion()
        {
            return new PDO(DBCom::$dbConParam, DBCom::$dbUsername, DBCom::$dbPassword);
        }

        /**
         * Obtient les informations pour un utilisateur en fonction de son adresse email
         * @param string $userEmail email de l'utilsateur
         * @return array fetchall des données (donc tableau de tableau)
         */
        public static function getUserData(string $userEmail)
        {
            // Crée la commande et retourne le résultat
            $sql = "SELECT * FROM `t_user` WHERE `useNickname` = \"$userEmail\"";
            return self::getData($sql);
        }

        /**
         * Execute une commande SELECT
         * @param string $sql Commande à executer
         * @param int $fetchType Type du fetch à effectuer
         * @return array fetchall des données (donc tableau de tableau)
         */
        private static function getData(string $sql, int $fetchType = PDO::FETCH_BOTH)
        {
            // Crée la connexion à la BD
            $dbConnection = self::createConnexion();


            // Execute la commande
            $result = $dbConnection->query($sql);

            // Fetch uniquement si le résultat n'est pas vide
            if ($result != null) {

                // Obtient les tableaus avec chaque ligne
                $result = $result->fetchAll($fetchType);
            }

            // Se déconnecte et retourne le résultat
            unset($dbConnection);
            return $result;
        }

        /**
         * Obtient les livres
         * @param int $pageNumber Numéro de la page à afficher
         * @param int $numberMaxOfBook Nombre maximum de livre à prendre
         * @return array fetchall des données (donc tableau de tableau)
         */
        public static function getBooks(int $pageNumber, int $numberMaxOfBook)
        {
            // Calcul la limite inférieure
            $limit = ($pageNumber - 1) * $numberMaxOfBook;

            // Crée la commande
            $sql = "SELECT * FROM `t_books` ORDER BY idBook DESC LIMIT $limit, $numberMaxOfBook";

            // Retourne le résultat
            return self::getData($sql, PDO::FETCH_ASSOC);
        }

        /**
         * Obtient le nombre de livre total dans la BD
         * @return int nombre de livre dans la BD
         */
        public static function getNumberOfBook()
        {
            $sql = "SELECT COUNT(idBook) FROM `t_books`";

            return self::getData($sql)[0][0];
        }

        /**
         * Obtient un livre avec un ID
         * @param int $bookId Id du livre
         * @return array fetchall des données (donc tableau de tableau)
         */
        public static function getBookWithId(int $bookId)
        {
            $sql = "SELECT booTitle, booPageNumber, booExtractLink, booSummary, booReleaseYear, booPictureLink, autName, autFirstname, btName, ediName, useNickname\n"
                . "FROM `t_books`\n"
                . "NATURAL JOIN t_author\n"
                . "NATURAL JOIN t_booktype\n"
                . "NATURAL JOIN t_editor\n"
                . "NATURAL JOIN t_user\n"
                . "WHERE idBook = $bookId";

            return self::getData($sql);
        }

        /**
         * Obtient toutes les categories dans la BD
         * @return array fetchall des données (donc tableau de tableau)
         */
        public static function getAllCategory()
        {
            $sql = "SELECT * FROM `t_category`";

            return self::getData($sql);
        }

        /**
         * Obtient tous les types de livre dans la BD
         * @return array fetchall des données (donc tableau de tableau)
         */
        public static function getAllType()
        {
            $sql = "SELECT * FROM `t_booktype`";

            return self::getData($sql);
        }

        /**
         * Obtient toutes les catégory auxquelles un livre appartient
         * @param int $bookId Id du livre
         * @return array fetchall des données (donc tableau de tableau)
         */
        public static function getAllCategoryForABook(int $bookId)
        {
            $sql = "SELECT catName, catDescription FROM `t_category`"
                . " NATURAL JOIN `t_categorize`"
                . " WHERE idBook = $bookId";

            return self::getData($sql);
        }

        /**
         * Ajoute un livre à la BD
         * @param array $verifiedPostArray tableau avec les données du nouveau livre vérifié
         * @return int id de la valeur inséré, 0 s'aucune valeur n'a été insérée
         */
        public static function addBook(array $verifiedPostArray)
        {
            try {
                $values = ["booTitle" => $verifiedPostArray['bookName'], "booPageNumber" => $verifiedPostArray['nbPage'], "booExtractLink" => $verifiedPostArray['bookExtract'], "booSummary" => $verifiedPostArray['summary'], "booReleaseYear" => $verifiedPostArray['releaseYear'], "booPictureLink" => $verifiedPostArray['bookPicture'], "idBookType" => $verifiedPostArray['selType'], "idAuthor" => $verifiedPostArray['idAuthor'], "idEditor" => $verifiedPostArray['idEditor'], "idUser" => $verifiedPostArray['idUser']];

                //Récupère le numéro du livre
                $idBook = self::saveData("t_books", $values);

                //Ajoute les catégories
                foreach ($verifiedPostArray['bookCategory'] as $category) {
                    self::saveData("t_categorize", ["idBook" => $idBook, "idCategory" => $category]);
                }

                //renvoie l'id du livre
                return $idBook;
            } catch (mysqli_sql_exception $exception) {
                print_r($exception);
                return null;
            }
        }

        /**
         * Obtient l'id d'un auteur en fonction de son nom et prénom
         * @param string $name Nom de l'auteur
         * @param string $firstname Prénom de l'auteur
         * @return array Un tableau contenant l'id de l'auteur, et un bool indiquant si il a du être créé ou non
         */
        public static function getAuthor(string $name, string $firstname)
        {
            //chercher le nom et prénom dans la base de donnée
            $sql = "SELECT `idAuthor` FROM `t_author` WHERE `autName` = \"$name\" AND `autFirstname` = \"$firstname\"";

            $output[0] = self::getData($sql);

            //Si l'auteur est déjà dans la base de donnée
            if ($output[0] != null) {
                //retourne simplement son ID
                $output[0] = $output[0][0][0];
                $output[1] = false;

                return $output;
            } else {

                //l'ajoute à la base de donnée, et renvoie son ID
                $output[0] = self::saveData("t_author", array("autName" => $name, "autFirstname" => $firstname));
                $output[1] = true;

                return $output;
            }

        }

        /**
         * Obtient l'id d'un editeur en fonction de son nom
         * @param string $name Nom de l'éditeur
         * @return array Un tableau contenant l'id de l'éditeur, et un bool indiquant si il a du être créé ou non
         */
        public static function getEditor(string $name)
        {
            //chercher le nom dans la base de donnée
            $sql = "SELECT `idEditor` FROM `t_editor` WHERE `ediName` = \"$name\"";

            $output[0] = self::getData($sql);

            //Si l'éditeur est déjà dans la base de donnée
            if ($output[0] != null) {
                //retourne simplement son ID
                $output[0] = $output[0][0][0];
                $output[1] = false;
                return $output;
            } else {
                //l'ajoute à la base de donnée, et renvoie son ID
                $output[0] = self::saveData("t_editor", array("ediName" => $name));
                $output[1] = true;
                return $output;
            }

        }

        /**
         * Obtient toutes les notes données à un livre
         * @param int $bookId Id du livre
         * @return array Tableau avec les données
         */
        public static function getRateForBook(int $bookId)
        {
            $sql = "SELECT ratRating FROM `t_rating` WHERE idBook = $bookId";

            return self::getData($sql);
        }

        /**
         * Ajoute ou modifie la note d'un utilisateur pour un livre
         * @param int $userId Id de l'utilisateur
         * @param int $bookId Id de livre
         * @param int $newRate Note donnée par l'utilisateur au livre
         * @return int id de la valeur inséré, 0 s'aucune valeur n'a été insérée
         */
        public static function setRateForUserAndBook(int $userId, int $bookId, int $newRate)
        {
            // Obtient la note actuel de l'utilisateur
            $currentRate = self::getRateForUserAndBook($userId, $bookId);

            // Enregistre un tableau avec les valeurs qu'il faudra enregistrer
            $values = ["ratRating" => $newRate, "idUser" => $userId, "idBook" => $bookId];

            // Si l'utilisateur n'avait pas encore mis de note la sauvegarde sinon la met à jour
            if (empty($currentRate)) {
                self::saveData("t_rating", $values);
            } else {
                self::updateData("t_rating", "idUser = $userId AND idBook = $bookId", $values);
            }
        }

        /**
         * Obtient la note pour un livre donné par un utilisateur
         * @param int $userId ID de l'utilisateur
         * @param int $bookId ID du livre
         * @return array tableau avec les données
         */
        public static function getRateForUserAndBook(int $userId, int $bookId)
        {
            $sql = "SELECT ratRating FROM `t_rating` WHERE idUser = $userId AND idBook = $bookId";

            return self::getData($sql);
        }

        /**
         * Met à jours des données dans une table
         * @param string $table Nom de la table où il faut mettre à jour les données
         * @param string $condition Condition de la mise à jour
         * @param string $rowValues Tableau avec les données à mettre à jour (clé = nom de la colonne et valeur = valeur correspondante)
         * @return string true si réussi, false sinon
         */
        private static function updateData(string $table, string $condition, array $rowValues)
        {
            // Se connecte à la BD
            $dbConnection = self::createConnexion();

            // Initialise un tableau avec les valeurs pour l'execution de la commande
            $values = [];
            foreach ($rowValues as $key => $value) {
                $values[":$key"] = $value;
            }

            // Crée la commande avec des variables SQL
            $sql = "UPDATE " . $table . " SET ";
            foreach ($rowValues as $key => $value) {
                // Va à la fin du tableau pour pouvoir savoir si on est à la dernière valeurs du tableau
                end($rowValues);
                $sql .= $key . " = :" . $key . (key($rowValues) === $key ? " " : ", ");
            }
            $sql .= "WHERE " . $condition;

            // Execute la commande, coupe la connexion et retourne si la commande à réussi
            if ($dbConnection->prepare($sql)->execute($values)) {
                unset($dbConnection);
                return true;
            } else {
                unset($dbConnection);
                return false;
            }
        }
    }

?>
