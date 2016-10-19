<?php

namespace App\Http\Middleware;

use App\Http\Strings\Cookie\Words;
use App\Http\Utils\UserSession;
use Closure;
use Illuminate\Support\Facades\Redirect;
class NotLoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        

        if(!UserSession::isUserLoggedIn($request)){
            return $next($request);
        }else{
            return Redirect::to('/');
        }

    }
}
