<?php
namespace src\helpers;

class md5 
{
    public static function generateSalt($n1=1, $n2=10) {
        return substr(md5(random_int(100,999)), $n1, $n2);
    }
    
    public static function hashPassword($password, $salt='') {
        if(empty($salt)) {
            $salt = self::generateSalt();
        }
        return md5($salt . $password);
    }
}
