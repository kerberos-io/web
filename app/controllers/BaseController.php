<?php namespace Controllers;

use Controller;
use Repositories\ImageHandlerInterface as ImageHandlerInterface;
use Repositories\ConfigReaderInterface as ConfigReaderInterface;

class BaseController extends Controller
{
    use \Traits\GetVersions;
    
	public function __construct(){}
}
