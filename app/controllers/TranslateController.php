<?php namespace Controllers;

use Auth, Input, Session, Lang;
use View, Response, Redirect;
use Models\Config\FileLoader as FileLoader;

class TranslateController extends BaseController
{
    public function index($page)
    {
        if($page)
        {
            return Response::json(Lang::get($page));
        }
    }
}   