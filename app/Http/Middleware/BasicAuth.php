<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SimpleAuth
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
        $loggedIn = Auth::guard($guard)->check();
        if(!$loggedIn)
        {
            if($request->ajax())
            {
                response('Unauthorized', 401);
            }
            else
            {
                if(Config::get('kerberos')['installed'])
                {
                    return redirect('/login');
                }
                else
                {
                    return redirect('/welcome');
                }
            }
        }

        return $next($request);
    }
}
