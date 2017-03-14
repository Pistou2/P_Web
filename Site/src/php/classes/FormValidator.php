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
        $loginFile = fopen("../../resources/login.txt", "r");

        //do while we are logged or we reached the end of the file
        do {
            $currentLine = str_replace("\r\n", "", fgets($loginFile));
            $lineParts = explode("\t",$currentLine,3);
            //check the username
            if ($lineParts[1] == $email) {
                //check the password (limit of 3 in the explode to let the password contains tabs)
                if (password_verify($password, $lineParts[2])) {
                    return $lineParts[0];
                }
            }
        } while (!feof($loginFile));
        //if we reached here, that mean we didn't matched anything
        return null;
    }
}