<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(is_null($guard)){
            $guard = config('auth.defaults.guard');
        }else{
            Config::set('auth.defaults.guard', $guard);
        }
        if (auth()->check()) {
            $route = config('auth.guards.'.$guard.'.routes.home', null);
            if(!$route){
                $route = 'home';
            }

            return redirect()->route($route);
        }
        return $next($request);
    }
}
