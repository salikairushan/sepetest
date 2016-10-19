<?php namespace App\Http\ModelWrappers\V1;

/**
 * Created by PhpStorm.
 * User: Michika
 * Date: 5/20/16
 * Time: 12:31 PM
 */
use App\Cookies;
use App\Http\Strings\Cookie\Words;
use App\Http\Utils\Encryptions;
use App\Http\Utils\StringOperations;
use Carbon\Carbon;
use Illuminate\Cookie\CookieJar;

/**
 * Class CookiesWrapper
 * The class will handle the all the cookie related activities
 * @package App\Http\ModelWrappers\V1
 */
class CookiesWrapper
{
    /**
     * @param $content
     * @param $user_id
     * @param $content2
     * @return bool
     * @throws \App\Http\Utils\Exception
     * This will save the cookie into the database
     */
    private static function  saveCookie($content2,$content, $user_id,$time){
        $cookie = new Cookies();
        if(StringOperations::IsNullOrEmptyStringArrayOfWords(array($content2,$content,$user_id))){

            return false;
        }
        /*
         * avoid duplication the cookie for the same user
         */
        if(self::checkCookieAll($content2,$content)) {
            return false;
        }
        $cookie->user_id = $user_id;
        $cookie->content = $content;
        $cookie->content2 = $content2;
        $cookie->time_period = Carbon::now()->addMinutes($time);
        $cookie->save();
        return true;
    }

    /**
     * @param $content
     * @param $content2
     * @param $user_id
     * @return bool
     * check for the cookie whether it's belong to the user
     */
    public static function checkCookie($content2,$content, $user_id)
    {
        /*
         * checking for the cookie whether it's belong to the user
         */
        $cookie = null;
        $cookie = Cookies::where('user_id','=',$user_id)->where('content','=',$content)->where('content2','=',$content2)->first();
        if(is_null($cookie)){
            return false;
        }
        return true;
    }

    public static function checkCookieAll($content2,$content)
    {
        /*
         * checking for the cookie whether it's belong to the user
         */
        $cookie = null;
        $cookie = Cookies::where('content','=',$content)->where('content2','=',$content2)->first();
        if(is_null($cookie)){
            return false;
        }
        return true;
    }

    /**
     * @param $user_id
     * @param $time
     * @param $content2
     * @param $content
     * @return string
     * This function will create a cookie for the given user, this method will do the basic validation only, recommend validate user details
     * before passing the user_id
     */
    public static function createCookie($user_id,$time = 60,$content,$content2,&$response){
        if(!self::saveCookie($content2,$content,$user_id,$time)){
            return false;
        }
        $cook = new CookieJar();
        $response->withCookie($cook->make(Words::$authCookie, $content, $time, '/',\App\Http\Strings\Settings\Words::getSiteDomain() , \App\Http\Strings\Settings\Words::getIsHTTPS(),false))->cookie($cook->make(Words::$authCookie2, $content2, $time, '/',\App\Http\Strings\Settings\Words::getSiteDomain() , \App\Http\Strings\Settings\Words::getIsHTTPS(), false));
        return true;
    }
    public static function removeCookie($user_id,$content,$content2){
        $cookie = null;
        $cookie = Cookies::where('user_id','=',$user_id)->where('content','=',$content)->where('content2','=',$content2)->first();
        if(is_null($cookie)){
            return true;
        }else{
            $cookie->delete();
        }
        return true;
    }
    public static function getUser($content,$content2){
        $userId = null;
        $userId = Cookies::where('content','=',$content)->where('content2','=',$content2)->first();
        if(!is_null($userId)){
            $user = null;
            $user = usersWrapper::getUserByID($userId->user_id);
            return $user;
        }
        return null;
    }

}