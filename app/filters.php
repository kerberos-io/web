<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/


App::before(function($request)
{
	/*
	|-----------------------------------------------------------
	| Authentication Kerberos.web - Simpleauth by cedricverst
	|-----------------------------------------------------------
	|	
	| When you first open the kerberos web application a user
	| needs to sign-in, it can sign-in with following credentials.
	|
	*/

	$users = Config::get('kerberos.users');
	Auth::getProvider()->setUsers($users);

	/*
	|-----------------------------------------------------------
	| Set language
	|-----------------------------------------------------------
	*/

	$language = Session::get('language','en'); // english will be the default language.
   	App::setLocale($language);
	
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			if(Config::get('kerberos')['installed'])
			{
				return Redirect::guest('login');
			}
			else
			{
				return Redirect::guest('welcome');
			}
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic("username");
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});


/*
|--------------------------------------------------------------------------
| Config Protection filter
|--------------------------------------------------------------------------
|
| The config filter is responsible to check if a valid configuration file is available.
| if not the web application won't work properly.
|
*/

Route::filter('validConfig', function()
{
	$isValid = true;

	$config = Config::get("app.config");
	$data = ['config' => $config, 'message' => ''];

	if(is_dir($config))
	{
		$reader = App::make('Repositories\ConfigReader\ConfigReaderInterface');	
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
});

/*
|--------------------------------------------------------------------------
| Capture Protection filter
|--------------------------------------------------------------------------
|
| The capture filter is responsible to check if the capture directory exists.
| if not the web application won't work properly.
|
*/

Route::filter('validCapture', function()
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
});
