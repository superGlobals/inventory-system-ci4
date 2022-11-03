<?php

namespace App\Libraries;

class Hash
{
    /**
     * Hash users password
     */
    public static function encrypt($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Check user password if correct using password_verify
     */
    public static function check($userPass, $dbUserPass)
    {
        if(password_verify($userPass, $dbUserPass))
        {
            return true;
        }

        return false;
    }
}