<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6/7/2016
 * Time: 6:27 PM
 */

namespace App\Http\Utils;


use Mockery\CountValidator\Exception;

/**
 * Class Encryptions
 * @package App\Http\Utils
 * This Class will handle the Encryption for password and the cookies
 */

class Encryptions
{
    /**
     * @param $password
     * @return null
     * @throws \App\Http\Utils\Exception
     * Get the Encrypted password
     */
    public static function getPassword($password)
    {
        $pass = null;
        if( !StringOperations::IsNullOrEmptyStringSingleWord($password) ){
            $pass = hash('sha512',$password);
        }else{
            throw new Exception('Password Cannot be empty or null');
        }
        return $pass;
    }

    /**
     * @param int $length
     * @return mixed
     * Get the encrypted cookie string
     */
    public static function getCookieString($length = 32)
    {
        if ( function_exists('mcrypt_create_iv') ) {
            return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
        }else{
            throw new Exception('PHP ,crypt module must be installed');
        }
    }
}