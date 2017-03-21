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

        private static function getData($sql)
        {
            $dbConnection = new PDO(DBCom::$dbConParam, DBCom::$dbUsername, DBCom::$dbPassword);

            return $dbConnection->query($sql);
        }

        public static function saveData($table, $rowValues)
        {
            $dbConnection = new PDO(DBCom::$dbConParam, DBCom::$dbUsername, DBCom::$dbPassword);

            $values = [];
            foreach ($rowValues as $value) {
                $values[] = '"'.$value.'"';
            }

            $sql = "INSERT INTO ".$table." (".implode(", ", array_keys($rowValues)).") VALUES (".implode(", ", $values).");";

            echo $sql;

            if($dbConnection->prepare($sql)->execute()){
                return true;
            }
            else{
                return false;
            }
        }

        public static function getUserData ($userEmail){
            $sql = "SELECT * FROM `t_user` WHERE `useNickname` = \"$userEmail\"";

            return self::getData($sql);
        }
    }
