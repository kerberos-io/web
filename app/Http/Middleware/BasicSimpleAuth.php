<?php

namespace App\Http\Middleware;

use Config;
use Closure;
use Illuminate\Support\Facades\Auth;

class BasicSimpleAuth
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
        return Auth::guard($guard)->basic("username") ?: $next($request);
    }
}
