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
 * User: Alex
 * Date: 6/5/2016
 * Time: 2:53 PM
 */

namespace App\Http\Utils;


/**
 * Class StringOperations
 * Description: This class is used for all of the string operations, which ara done through the project
 * @package App\Http\Utils
 */
class StringOperations
{
    /**
     * @param $word
     * Description: This function take one single word as a parameter and check where it it null of empty,
     * If the parameter is empty or null then return true otherwise false
     * @return bool
     * @throws Exception
     */
    public static function IsNullOrEmptyStringSingleWord($word){
        if(is_array($word)){
            throw new Exception('The parameter you passed is an array, To check array of words use IsNullOrEmptyStringArrayOfWords Function');
        }
        return (!isset($word) || trim($word)==='');
    }

    /**
     * @param $array
     * Description: This function take array of words as a parameter and check where it it null of empty,
     * If the parameter is empty or null then return true otherwise false
     * @return bool
     * @throws Exception
     */
    public static function IsNullOrEmptyStringArrayOfWords($array){
        if(!is_array($array)){
            throw new Exception('The parameter you passed is not an array, To check a single word use IsNullOrEmptyStringSingleWord Function');
        }
        for($x=0; $x<count($array); $x++){
            if(!isset($array[$x]) || trim($array[$x])===''){
                return true;
            }
        }
        return false;
    }
    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}