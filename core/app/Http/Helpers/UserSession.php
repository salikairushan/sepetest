<?php
/**
 * Created by PhpStorm.
 * User: alexv
 * Date: 9/14/2016
 * Time: 9:30 PM
 */

namespace App\Http\Helpers;


use App\Http\Strings\Session\Words;

class UserSession
{
    public static function isLogged()
    {
        $userDTO = null;
        $userDTO = session(Words::$UserObject,null);
        if($userDTO == null){
            return false;
        }else{
            return true;
        }
    }
    public static function getUserLevel()
    {
        $userDTO = null;
        $userDTO = session(Words::$UserObject,null);
        if($userDTO == null){
            return -1;
        }else{
            $userDTO = unserialize($userDTO);
            $user = $userDTO->user;
            return $user->role;
        }
    }
    public static function getUserEmail()
    {
        $userDTO = null;
        $userDTO = session(Words::$UserObject,null);
        if($userDTO == null){
            return -1;
        }else{
            $userDTO = unserialize($userDTO);
            $user = $userDTO->user;
            return $user->email;
        }
    }
}