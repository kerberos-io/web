<?php namespace App\Http\Middleware;

use Config;
use Closure;
use View;

class HasCaptureDirectory
{
    /*
    |-----------------------------
    | Capture Protection
    |-----------------------------
    |
    | The capture middleware is responsible to check if the capture directory exists.
    | if not the web application won't work properly.
    |
    */

    public function handle($request, Closure $next, $guard = null)
    {
        $isValid = true;

        $capture = public_path() . Config::get("app.filesystem.disk.path");
        $data = ['capture' => $capture, 'message' => ''];

        if(!is_dir($capture))
        {
          $isValid = false;
          $capture = rtrim($capture, '/');

          if(!is_link($capture))
          {
            $data['message'] = "It looks like the capture directory is missing.<br/> Please create the directory: <b>".$data['capture']."</b>.";
          }
          else
          {
            // Check if link exists
            $data['message'] = "It looks like the capture directory is missing.<br/> Please create the directory: <b>".readlink($capture)."</b>.";
          }
        }

        if(!$isValid)
        {
          return View::make('errors.config-missing', $data);
        }

        return $next($request);
    }
}
