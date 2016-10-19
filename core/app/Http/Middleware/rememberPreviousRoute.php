<?php

namespace App\Http\Middleware;
use App\Http\Strings\Session\Words;
use App\Http\Utils\StringOperations;
use Closure;
use Illuminate\Support\Facades\URL;

class rememberPreviousRoute
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
        $uri=null;
        $uri = $request->path();
        if(StringOperations::IsNullOrEmptyStringSingleWord($uri)){
            session([Words::$PrevRequest => '/']);
        }else{
            session([Words::$PrevRequest => $uri]);
        }
        return $next($request);
    }
}
