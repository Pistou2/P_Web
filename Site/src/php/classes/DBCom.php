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
                unset($dbConnection);
                return true;
            } else {
                unset($dbConnection);
                return false;
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

            return $dbConnection->query($sql)->fetchAll($fetchType);
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
                ."FROM `t_books`\n"
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

        //TODO Images
        //TODO auteur, éditeur
        public static function addBook(array $verifiedPostArray)
        {
            try {
                $values = ["booTitle" => $verifiedPostArray['bookName'], "booPageNumber" => $verifiedPostArray['nbPage'], "booExtractLink" => "TODO", "booSummary" => $verifiedPostArray['summary'], "booReleaseYear" => $verifiedPostArray['releaseYear'], "booPictureLink" => "TODO", "idBookType" => $verifiedPostArray['selType'], "idAuthor" => 0, "idEditor" => 0, "idUser" => $verifiedPostArray['idUser']];

                self::saveData("t_books",$values);
                return true;
            } catch (mysqli_sql_exception $exception) {
                print_r($exception);
                return false;
            }
        }
    }
