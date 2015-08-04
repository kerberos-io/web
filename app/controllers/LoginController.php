<?php

namespace controllers;

use Auth;
use Input;
use Redirect;
use Response;
use View;

class LoginController extends BaseController
{
    /**
     *  Show the login screen.
     */
    public function index()
    {
        return View::make('login');
    }

    /**
     *  Login user.
     */
    public function login()
    {
        $credentials = Input::all();

        if ($user = Auth::attempt(['username' => $credentials['username'],
                                  'password' => $credentials['password'], ])) {
            return Response::json($user);
        }

        return Response::json(['error' => true], 400);
    }

    /**
     *  Logout user.
     */
    public function logout()
    {
        Auth::logout();

        return Redirect::to('login');
    }
}
