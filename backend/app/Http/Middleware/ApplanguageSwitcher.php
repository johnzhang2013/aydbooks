<?php

namespace App\Http\Middleware;

use Closure;
use App;

class ApplanguageSwitcher
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
        //Get the request header[applocale]
        $applocale = $request->header('applocale');
        
        if(empty($applocale) || $applocale == null){//set a default lang
            $applocale = 'en';
        }
        
        if(!App::isLocale($applocale)){
            App::setLocale($applocale);
        }
        
        return $next($request);
    }
}
