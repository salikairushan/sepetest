<?php

namespace App\Http\Controllers;

use App\Http\Utils\StringOperations;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Strings\Request\Words;
use App\Http\ModelWrappers\V1\usersWrapper;
use App\Http\Utils\Encryptions;
use App\Http\ModelWrappers\V1\CookiesWrapper;
use App\Http\ModelWrappers\V1\ResponseWrapper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;


class LoginController extends Controller
{
    /**
     * LoginController constructor.
     */
    function __construct()
    {
        $this->middleware('NotLoginCheck');
    }
    public function index(){
        return view('login.Login');
    }
    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \App\Http\Utils\Exception
     */
    public function login(Request $request)
    {
        $email = null;
        $password = null;
        $email = $request->input(Words::$email,'');
        $password = $request->input(Words::$password,'');
        $rememberMe = $request->input(Words::$rememberMe, 0);
        $response = new ResponseWrapper();
        $response->setDescription("Ok");
        response()->json($response->getResponse());
       if( usersWrapper::isUserRegisteredAndActive($email,$password) ){
           $returnUrl = "";
           if($request->session()->has(\App\Http\Strings\Session\Words::$PrevRequest))
           {
               if(!StringOperations::IsNullOrEmptyStringSingleWord($request->session()->get(\App\Http\Strings\Session\Words::$PrevRequest))){
                   $returnUrl = URL::to($request->session()->get(\App\Http\Strings\Session\Words::$PrevRequest));
               }else{
                   $returnUrl = URL::to('/');
               }

           }else{
               $returnUrl = URL::to('/');
           }
           $responseCookie = new RedirectResponse($returnUrl);
           $user = usersWrapper::getUser($email,$password);
           if( ($rememberMe === "on" ) ){
               while(true){
                   $content1 = Encryptions::getCookieString(200);
                   $content2 =Encryptions::getCookieString(200);
                   if(CookiesWrapper::createCookie($user->id,1440*30,$content1,$content2,$responseCookie)){
                       break;
                   }
               }

           }else{
               while(true){
                   $content1 = Encryptions::getCookieString(500);
                   $content2 =Encryptions::getCookieString(500);
                   if(CookiesWrapper::createCookie($user->id,3600,$content1,$content2,$responseCookie)){
                       break;
                   }
               }
           }
            return $responseCookie;
       }else{
           $response = new ResponseWrapper();
           $response->setCode(401);
           if(usersWrapper::isUserRegistered($email,$password)){
               $response->setDescription("Your Account is disabled,Contact Administrators");
           }else{
               $response->setDescription("Please Check your Username and Password");
           }

           return view('login.Login', ['loginDetails' => $response->getResponse(),'email' => $email]);
       }
    }
    
}
