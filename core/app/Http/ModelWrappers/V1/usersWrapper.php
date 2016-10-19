<?php
/*******************************************************
 * Copyright (C) 2016-2017 Makevitage Michika Iranga Perera <alexvista1234@gmail.com>
 *
 * This file is part of HYMNS project.
 *
 * HYMNS project can not be copied and/or distributed without the express
 * permission of Makevitage Michika Iranga Perera
 *******************************************************/
/**
 * Created by PhpStorm.
 * User: Michika
 * Date: 5/20/16
 * Time: 12:36 PM
 */

namespace App\Http\ModelWrappers\V1;
use App\Http\Utils\Encryptions;
use App\User;
use App\Http\Utils\StringOperations;

class usersWrapper
{
    /**
     * @param $email
     * @param $password
     * @return null
     * @throws \App\Http\Utils\Exception
     * get the user by givin email and password
     */
    public static function getUser($email, $password)
    {
        $user = null;
        $param = array($email,$password);
        if(StringOperations::IsNullOrEmptyStringArrayOfWords($param) && self::isUserRegistered($email,$password)){
            return null;
        }

        $passwordHashed = Encryptions::getPassword($password);
        //$passwordHashed = $password;
        $user = User::where('email','=',$email)->where('password','=',$passwordHashed)->first();
        $user->password = "";
        return $user;
    }

    /**
     * @param $email
     * @param $password
     * @param $name
     * @param string $gender
     * @return User|null
     * @throws \App\Http\Utils\Exception
     * create a new user
     */
    public static function newUser($email, $password, $name, $gender = "N")
    {
        $param = array($email,$password,$name);
        if($gender != "M" && $gender != "F"){
            $gender = "N";
        }
        if(StringOperations::IsNullOrEmptyStringArrayOfWords($param)){
            return null;
        }
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Encryptions::getPassword($password);
        $user->active = true;
        $user->gender = $gender;
        $user->save();
        $user->password = "";
        return $user;

    }

    /**
     * @param $email
     * @param $password
     * @return bool
     * @throws \App\Http\Utils\Exception
     * check for the user
     */
    public static function isUserRegistered($email, $password)
    {
        $param = array($email,$password);
        if(StringOperations::IsNullOrEmptyStringArrayOfWords($param)){
            return false;
        }
        $passwordHashed = Encryptions::getPassword($password);
        //$passwordHashed = $password;
        $user = null;
        $user = User::where('email','=',$email)->where('password','=',$passwordHashed)->first();
        if(!is_null($user)){
            return true;
        }else{
            return false;
        }
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     * @throws \App\Http\Utils\Exception
     * check for the user
     */
    public static function isUserRegisteredAndActive($email, $password)
    {
        $param = array($email,$password);
        if(StringOperations::IsNullOrEmptyStringArrayOfWords($param)){
            return false;
        }
        $passwordHashed = Encryptions::getPassword($password);
        //$passwordHashed = $password;
        $user = null;
        $user = User::where('email','=',$email)->where('password','=',$passwordHashed)->where('active','=',true)->first();
        if(!is_null($user)){
            return true;
        }else{
            return false;
        }
    }
    /**
     * @param $id
     * @return null
     * @throws \App\Http\Utils\Exception
     * Get the user by passing the user ID
     */
    public static function getUserByID($id)
    {
        $user = null;
        if(!StringOperations::IsNullOrEmptyStringSingleWord($id)){
            $user = User::where('id','=',$id)->first();
            $user->password = "";
        }
        return $user;
    }

}