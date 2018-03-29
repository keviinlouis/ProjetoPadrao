<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Illuminate\Http\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if(is_null($guard)){
            $guard = config('auth.defaults.guard');
        }else{
            Config::set('auth.defaults.guard', $guard);
        }

        if(!auth()->check()){
            if($request->isJson() || $request->expectsJson()){
                return response()->json([
                    'success' => false,
                    'data' => 'Requisição não autorizada'
                ], Response::HTTP_UNAUTHORIZED);
            }
            $route = config('auth.guards.'.$guard.'.routes.login', null);
            if(!$route){
                $route = 'login';
            }
            return redirect()->route($route);
        }

        return $next($request);
    }
}
