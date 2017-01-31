<?php namespace Controllers;

use Auth, Input, Session, Config;
use View, Response, Redirect;
use Models\Config\FileLoader as FileLoader;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->kerberos = Config::get("kerberos");
        $this->fileLoader = new FileLoader(new \Illuminate\Filesystem\Filesystem(), app_path() . '/config');
    }

    /**
     *  Get current user
     */
    public function current()
    {
        $user = Auth::user();

        if($user)
        {
            return Response::json([$user]);
        }

        return Response::json(['error' => true], 400);
    }

    public function changeLanguage()
    {
        $language = Input::get('language');
        Session::put('language',$language);
        return Response::json(['language' => $language]);
    }

    public function install()
    {
        $input = Input::all();

        $config = $this->kerberos;
        $user = &$config['users'][0];
        $user['language'] = Session::get('language');
        $installed = &$config['installed'];
        $installed = true;

        if($input['username'] &&
            $input['password1'] === $input['password2'])
        {
            $user['username'] = $input['username'];
            $user['password'] = $input['password1'];
        } 

        $this->fileLoader->save($config, '', 'kerberos');

        return Response::json($user);
    }

    public function updateCurrent()
    {
        $input = Input::all();
        $config = $this->kerberos;
        $authedUser = Auth::user();

        // --------------------------------
        // Check if trying to update password

        $newPassword = null;

        if($input['currentPassword'] === $authedUser->getAuthPassword() &&
            $input['newPassword1'] === $input['newPassword2'])
        {
            $newPassword = $input['newPassword1'];
        }

        // ----------------------------------
        // Search for current users in config

        $users = &$config['users'];

        foreach($users as $key => &$user)
        {
            if($authedUser->username === $user['username'])
            {
                $user['username'] = $input['username'];
                $user['language'] = $input['language'];
                Session::put('language', $input['language']);

                if($newPassword)
                {
                    $user['password'] = $newPassword;
                }

                break;
            }
        }

        $this->fileLoader->save($config, '', 'kerberos');

        return Response::json($config); 
    }
}   
