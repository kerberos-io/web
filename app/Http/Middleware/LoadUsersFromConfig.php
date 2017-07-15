<?php namespace App\Http\Middleware;

use Config;
use Closure;
use Illuminate\Support\Facades\Auth;

class LoadUsersFromConfig
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
        $users = Config::get('kerberos.users');
        Auth::getProvider()->setUsers($users);

        return $next($request);
    }
}
