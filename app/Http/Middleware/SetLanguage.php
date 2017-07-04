<?php namespace App\Http\Middleware;

use App;
use Session;
use Closure;

class SetLanguage
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
        $language = Session::get('language','en'); // english will be the default language.
        App::setLocale($language);

        return $next($request);
    }
}
