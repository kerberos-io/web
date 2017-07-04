<?php namespace App\Http\Controllers;

use Auth, Input, Session;
use View, Response, Redirect;

class WelcomeController extends BaseController
{
    /**
     *  Show the login screen
     */
    public function index()
    {
        return View::make('welcome');
    }

    /**
     *  Login user
     */
    public function login()
    {
        $credentials = Input::all();

        if($user = Auth::attempt(["username" => $credentials["username"],
                                  "password" => $credentials["password"]]))
        {
            $user = Auth::user();
            $language = $user->language;
            Session::put('language',$language);
            return Response::json($user);
        }

        return Response::json(['error' => true], 400);
    }

    /**
     *  Logout user
     */
    public function logout()
    {
        Auth::logout();
        return Redirect::to('login');
    }
}
