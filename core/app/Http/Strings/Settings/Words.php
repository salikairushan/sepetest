<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6/27/2016
 * Time: 12:39 AM
 */

namespace App\Http\Strings\Settings;


use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Config;

class Words
{
    public static function getSiteDomain(){
        $var = config('app.cookieUrl');
        return $var;
    }
    public static function getIsHTTPS(){
        $var = config('app.cookieSSL');
        return $var;
    }
}