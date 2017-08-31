<?php namespace App\Http\Controllers;

use App, View, Config, Session;
use App\Http\Repositories\ImageHandler\ImageHandlerInterface as ImageHandlerInterface;
use App\Http\Repositories\ConfigReader\ConfigReaderInterface as ConfigReaderInterface;

class DashboardController extends BaseController
{
    public function __construct(ImageHandlerInterface $imageHandler, ConfigReaderInterface $reader)
    {
        parent::__construct($imageHandler, $reader);
        $this->imageHandler = $imageHandler;
        $this->reader = $reader;
        $this->config = Config::get("app.config");
        $this->kerberos = Session::get('kerberos', []);
        if(count($this->kerberos) == 0)
        {
            $this->kerberos = Config::get("kerberos");
            Session::put('kerberos', $this->kerberos);
        }
    }

    /****************************
     *  Show dashboard
     */
  	public function index()
  	{
        // ----------------------------------------------------------------------
        // Get last x days from the imagehandler -> move to BaseController

        $days = $this->imageHandler->getDays(5);

        $directory = $this->config;
        $settings = $this->reader->parse($directory)["instance"]["children"];
        $isActive = ($settings["condition"]["dropdown"]["Enabled"]["children"]["active"]["value"] === "true") ? "none" : "block";

        return View::make('dashboard', [
            'isActive' => $isActive,
            'cameraName' => $settings['name']['value'],
            'days' => $days,
            'kerberos' => $this->kerberos,
            'fps' => $settings['io']['dropdown']['Video']['children']['fps']['value'],
        ]);
  	}
}
