<?php
/**
 * Created by PhpStorm.
 * User: alexv
 * Date: 9/23/2016
 * Time: 7:39 AM
 */

namespace App\Http\Middleware;
use App\Http\Utils\UserSession;
use Closure;
use App\Http\Strings\Session\Words;
use App\Http\Utils\StringOperations;

class AdminCheck
{
    public function handle($request, Closure $next)
    {
        $user = null;
        $user = UserSession::GetUserWithRequest($request);
        // Admin -4 , Super Admin - 5 (role)
        if($user == null || $user->role < 4){
            return redirect('/login');
        }
        return $next($request);
    }
}