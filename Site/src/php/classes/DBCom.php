<?php

    /*
    *  ETML
    *  Auteur : Clément Dieperink
    *  Date : 21.03.2017
    *  Description :
    */

    class DBCom
    {
        private static $dbConParam = 'mysql:host=localhost;dbname=db_p_web';
        private static $dbUsername = 'root';
        private static $dbPassword = '.Etml-44';

        public static function saveUserData(string $email, string $hashedPassword, string $registeryDate)
        {
            $values = ["useNickname" => $email, "usePassword" => $hashedPassword, "useRegisteryDate" => $registeryDate];

            return self::saveData("t_user", $values);
        }

        private static function saveData(string $table, array $rowValues)
        {
            $dbConnection = new PDO(DBCom::$dbConParam, DBCom::$dbUsername, DBCom::$dbPassword);

            $values = [];
            foreach ($rowValues as $value) {
                $values[] = '"' . $value . '"';
            }

            $sql = "INSERT INTO " . $table . " (" . implode(", ", array_keys($rowValues)) . ") VALUES (" . implode(", ", $values) . ");";

            if ($dbConnection->prepare($sql)->execute()) {
                $lastId= $dbConnection->lastInsertId();
                unset($dbConnection);
                return $lastId;
            } else {
                unset($dbConnection);
                return 0;
            }
        }

        public static function getUserData(string $userEmail)
        {
            $sql = "SELECT * FROM `t_user` WHERE `useNickname` = \"$userEmail\"";

            return self::getData($sql);
        }

        private static function getData(string $sql, int $fetchType = PDO::FETCH_BOTH)
        {

            $dbConnection = new PDO(DBCom::$dbConParam, DBCom::$dbUsername, DBCom::$dbPassword);

            $result = $dbConnection->query($sql);

            //fetch uniquement si le résultat n'est pas vide
            if ($result != null) {
                $result = $result->fetchAll($fetchType);
            }

            unset($dbConnection);
            return $result;
        }

        public static function getAllBooks()
        {
            //TODO Paramètre optionnel pour recherche ?

            $sql = "SELECT * FROM `t_books`;";

            return self::getData($sql, PDO::FETCH_ASSOC);
        }

        public static function getBookWithId($bookId)
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

        public static function getAllCategory()
        {
            $sql = "SELECT * FROM `t_category`";

            return self::getData($sql);
        }

        public static function getAllType()
        {
            $sql = "SELECT * FROM `t_booktype`";

            return self::getData($sql);
        }

        public static function getAllCategoryForABook($bookId)
        {
            $sql = "SELECT catName, catDescription FROM `t_category`";
            $sql .= " NATURAL JOIN `t_categorize`";
            $sql .= " WHERE idBook = $bookId";

            return self::getData($sql);
        }

        public static function getFiveLastBook()
        {
            $sql = "SELECT * FROM `t_books` ORDER BY `idBook` DESC LIMIT 5";

            return self::getData($sql);
        }

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
         * @param string $name
         * @param string $firstname
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
         * @param string $name
         * @return array Un tableau contenant l'id de l'éditeur, et un bool indiquant si il a du être créé ou non
         */
        public static function getEditor(string $name)
        {
            //chercher le nom et prénom dans la base de donnée
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

    }
