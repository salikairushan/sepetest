<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 6/28/2016
 * Time: 11:07 PM
 */

namespace App\Http\Utils;


use App\Http\ModelWrappers\V1\CookiesWrapper;
use App\Http\Strings\Session\Words;
use Illuminate\Cookie\CookieJar;

class UserSession
{

    /**
     * @param $Auth1Cookie
     * @param $Auth2Cookie
     * @param $user
     * @return bool
     */
    public static function StoreUser($Auth1Cookie, $Auth2Cookie, $user){


        return true;
    }

    /**
     * @param $request
     * @return bool
     */
    public static function ResetSession(&$request)
    {
        $request->session()->flush();

        $cook = new CookieJar();
        \Cookie::queue($cook->make(\App\Http\Strings\Cookie\Words::$authCookie, null, -1, '/',\App\Http\Strings\Settings\Words::getSiteDomain() , \App\Http\Strings\Settings\Words::getIsHTTPS(),false));
        \Cookie::queue($cook->make(\App\Http\Strings\Cookie\Words::$authCookie2, null, -1, '/',\App\Http\Strings\Settings\Words::getSiteDomain() , \App\Http\Strings\Settings\Words::getIsHTTPS(),false));
        return true;
    }

    /**
     * @param $request
     * @return null
     * @throws Exception
     */
    public static function GetUserWithRequest(&$request)
    {
        $user = null;
        $cookie1 = null;
        $cookie2 = null;
        $cookie1 = $request->cookie(\App\Http\Strings\Cookie\Words::$authCookie);
        $cookie2 = $request->cookie(\App\Http\Strings\Cookie\Words::$authCookie2);
        $param = array($cookie1,$cookie2);
        if(StringOperations::IsNullOrEmptyStringArrayOfWords($param)){
            if ($request->session()->has(Words::$UserObject)){
                self::ResetSession($request);
            }
            return null;
        }else{
            if ($request->session()->has(Words::$UserObject)) {
                $userObject = unserialize($request->session()->get(Words::$UserObject));
                if($userObject->AuthCookie == $cookie1 && $userObject->Auth2Cookie == $cookie2){
                    return $userObject->user;
                }else{
                    self::ResetSession($request);
                    return null;
                }
            }else{
                $user = CookiesWrapper::getUser($cookie1,$cookie2);
                if(is_null($user)){
                    self::ResetSession($request);
                    return null;
                }else{
                    $UserObject = new UserSessionDTO();
                    $UserObject->setData($user,$cookie1,$cookie2);
                    $request->session()->put(Words::$UserObject, serialize($UserObject));
                    return $user;
                }
            }
        }
    }

    /**
     * @param $request
     * @return bool
     */
    public static function isUserLoggedIn(&$request)
    {
        $user = null;
        $user = self::GetUserWithRequest($request);
        if(is_null($user)){
            return false;
        }else{
            return true;
        }
    }

}
class UserSessionDTO
{
    public $user;
    public $AuthCookie;
    public $Auth2Cookie;

    /**
     * @param $user
     * @param $AuthCookie
     * @param $Auth2Cookie
     */
    public function setData($user, $AuthCookie, $Auth2Cookie)
    {
        $this->user = $user;
        $this->AuthCookie = $AuthCookie;
        $this->Auth2Cookie = $Auth2Cookie;
    }
}