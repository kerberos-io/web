<?php namespace App\Http\Controllers;

use App\Http\Repositories\ImageHandlerInterface as ImageHandlerInterface;
use App\Http\Repositories\ConfigReaderInterface as ConfigReaderInterface;

class BaseController extends Controller
{
    use \App\Traits\GetVersions;
	  public function __construct(){}
}
