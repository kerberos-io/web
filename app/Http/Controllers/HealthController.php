<?php namespace App\Http\Controllers;

use Response;

class HealthController extends BaseController
{
    public function __construct(){}

    /****************************
     *  Execute health check
     */

    public function index()
    {
        $health["status"] = true;

        // -------------
        // Do checks ...
            // change status if something went wrong.

        return Response::json($health);
    }
}
