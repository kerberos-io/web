<?php namespace App\Http\Middleware;

use Config;
use Closure;
use View;
use App;

class HasConfiguration
{
    /*
    |--------------------------------------------------------------------------
    | Config Protection
    |--------------------------------------------------------------------------
    |
    | The config middleware is responsible to check if a valid configuration file is available.
    | if not the web application won't work properly.
    |
    */

    public function handle($request, Closure $next, $guard = null)
    {
        $isValid = true;

        $config = Config::get("app.config");
        $data = ['config' => $config, 'message' => ''];

        if(is_dir($config))
        {
          $reader = App::make('App\Http\Repositories\ConfigReader\ConfigReaderInterface');
          $settings = $reader->read($config . '/config.xml');

          if(count($settings) == 0)
          {
            $isValid = false;
            $data['message'] = "One or more config files are missing in <b>".$data['config']."</b>. <br/>Please check if the <b>.xml</b> files are available.";
          }
        }
        else
        {
          $isValid = false;
          $data['message'] = "It looks like the config directory is missing.<br/> Please create the directory: <b>".$data['config']."</b>.";
        }

        if(!$isValid)
        {
          return View::make('errors.config-missing', $data);
        }

        return $next($request);
    }
}
