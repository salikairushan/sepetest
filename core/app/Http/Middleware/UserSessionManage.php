<?php
/**
 * Created by PhpStorm.
 * User: alexv
 * Date: 9/9/2016
 * Time: 12:41 AM
 */

namespace App\Http\Middleware;
use App\Http\Utils\UserSession;
use Closure;

class UserSessionManage
{
    public function handle($request, Closure $next)
    {
        UserSession::GetUserWithRequest($request);
        return $next($request);
    }
}