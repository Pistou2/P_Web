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
        //TODO Paramètre optionnel pour recherche?

        $sql = "SELECT * FROM `t_books`;";

        return self::getData($sql,PDO::FETCH_ASSOC);
    }
}
