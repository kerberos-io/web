<?php namespace App\Http\Controllers;

use Log, Input;
use View;

class WebhookController extends BaseController
{
    public function store()
	{
        $info = Input::all();
        Log::info($info);
        return '';
	}
}
