<?php namespace Controllers;

use View, Redirect, Input, Config, Response, URL;
use Models\Config\FileLoader as FileLoader;
use Repositories\ImageHandler\ImageHandlerInterface as ImageHandlerInterface;
use Repositories\ConfigReader\ConfigReaderInterface as ConfigReaderInterface;

class SettingsController extends BaseController
{
    public function __construct(ImageHandlerInterface $imageHandler, 
        ConfigReaderInterface $reader)
    {
        parent::__construct($imageHandler, $reader);
        $this->imageHandler = $imageHandler;
        $this->reader = $reader;
        $this->config = Config::get("app.config");
        $this->kerberos = Config::get("kerberos");
        $this->fileLoader = new FileLoader(new \Illuminate\Filesystem\Filesystem(), app_path() . '/config');
    }
    
    /********************************************
     *  Show the settings page.
     */ 

    public function index()
    {
        $directory = $this->config;
        $settings = $this->reader->parse($directory)["instance"]["children"];

        $days = $this->imageHandler->getDays(5);

        return View::make('settings',
        [
            'days' => $days, 
            'settings' => $settings,
            'kerberos' => $this->kerberos
        ]);
    }

    /********************************************
     *  Show the cloud page.
     */ 
    public function cloud()
    {
        $directory = $this->config;
            
        $settings = $this->reader->parse($directory)["instance"]["children"]['cloud']['dropdown']['S3']['children'];
        $days = $this->imageHandler->getDays(5);

        return View::make('cloud',
        [
            'days' => $days, 
            'settings' => $settings,
            'isUpdateAvailable' => $this->isUpdateAvailable()
        ]);
    }

    public function getConfiguration()
    {
        return $this->kerberos;
    }

    public function changeProperties()
    {
        $config = $this->kerberos;

        $properties = Input::get();

        foreach ($properties as $key => $property)
        {
            $config[$key] = $property;
        }

        $this->fileLoader->save($config, '', 'kerberos');
        
        return $config;
    }

    /********************************
     *  Update web interface config
     */
    public function updateWeb()
    {
        $config = $this->kerberos;

        $properties = Input::except("_token");

        foreach ($properties as $key => $property)
        {
            $config[$key] = $property;
        }

        $this->fileLoader->save($config, '', 'kerberos');
        
        return Redirect::back();
    }

    /******************************************************************
     *  Get new settings from the settings page.
     *
     *      - update the configuration files of a certain directory
     *      with the correct settings.
     */ 

    public function update()
    {
        $settings = Input::except("_token");

        foreach($settings as $name => $setting)
        {
            // ----------------------------------------------------------------------
            // There can be multiple dropdowns (options), we should concatenate them

            $version = explode(":", $name);
            if(count($version) > 1)
            {
                // ----------------
                // Remove old name

                unset($settings[$name]);

                // ----------------
                // Create new name

                $version = $version[count($version)-1];
                $name = rtrim($name, ":" . $version);

                if(array_key_exists($name, $settings)) 
                {
                    $settings[$name] .= "," . $setting;
                }
                else
                {
                    $settings[$name] = $setting;
                }
            }
        }
        
        try
        {
            $this->reader->save($this->config, $settings);
        }
        catch(\Exception $ex)
        {
            $data = ['message' => ''];

            if(strpos($ex, 'Permission denied') !== false)
            {
                $data['message'] = $ex;
                return View::make('errors.permission-denied', $data);
            }
        }

        return Redirect::back();
    }
    
    /******************************************************************
     *  Edit a piece of a configuration file.
     */ 
    private function getPiece($config, array $keys)
    {
        $settings = $this->reader->read($this->config . '/'. $config);
        
        foreach($keys as $key)
        {
            if($settings->$key)
            {
                $settings = &$settings->$key;   
            }
        }
        
        if($settings)
        {
            return $settings;
        }
        
        return null;
    }
    
    /*******************************************
    *   Get and set name of the kerberos instance
    */
    
    public function getName()
    {
        $instance["name"] = $this->getPiece("config.xml", ["instance", "name"])->__toString();
        return Response::json($instance);
    }
    
    public function updateName()
    {
        if(Input::get('name') != '')
        {
            $settings["config__instance__name"] = Input::get('name');
            
            $this->reader->save($this->config, $settings);
        }
        
        return $this->getName();
    }
    
    /*******************************************
    *   Get and set the conditions.
    */
    
    public function getConditions()
    {
        $instance = explode(',', $this->getPiece("config.xml", ["instance", "condition"])->__toString());
        return Response::json($instance);
    }
    
    public function updateConditions()
    {
        if(Input::get('value') != '')
        {
            $settings["config__condition"] = implode(',',Input::get('value'));
        }
        
        $this->reader->save($this->config, $settings);
        
        return $this->getConditions();
    }
    
    /*******************************************
    *   Get and set the "Enabled" condition.
    */

    public function getConditionEnabled()
    {
        $instance = $this->getPiece("condition.xml", ["Enabled"]);
        return Response::json($instance);
    }

    public function updateConditionEnabled()
    {
        $settings = [];
        
        if(Input::get('active') != '')
        {
            $settings["condition__Enabled__active"] = Input::get('active');
        }

        if(Input::get('delay') != '')
        {
            $settings["condition__Enabled__delay"] = Input::get('delay');
        }

        $this->reader->save($this->config, $settings);

        return $this->getConditionEnabled();
    }

   public function getStream()
   {
        // -----------------------------------------
        // The web can run inside a docker container

        $output = shell_exec("[ -f /.dockerenv ] && echo true || echo false");

        if(trim($output) === "true")
        {   
            $url = URL::to('/') . '/stream';
            $port = '8889';
        }
        else
        {
            $instance = explode(',', $this->getPiece("stream.xml", ["Mjpg","streamPort"])->__toString());
            $url = parse_url(URL::to('/'), PHP_URL_HOST);
            $port = $instance[0];
            $url = 'http://' . parse_url(URL::to('/'), PHP_URL_HOST) . ':' . $port;
        }

        return Response::json([
            'url' => $url,
            'port' => $port
        ]);
   }


    /*******************************************
    *   Get and set the ios.
    */
    
    public function getIos()
    {
        $instance["devices"] = explode(',', $this->getPiece("config.xml", ["instance", "io"])->__toString());
        return Response::json($instance);
    }
    
    public function updateIos()
    {    
        if(Input::get('value') != '')
        {
            $settings["config__instance__io"] = implode(',', Input::get('value'));
        }

        $this->reader->save($this->config, $settings);
        
        return $this->getIos();
    }
    
    /*******************************************
    *   Get and set the "Webhook" io.
    */

    public function getIoWebhook()
    {
        $instance = $this->getPiece("io.xml", ["Webhook"]);
        return Response::json($instance);
    }

    public function updateIoWebhook()
    {
        if(Input::get('active') != '')
        {
            $settings["io__Webhook__url"] = Input::get('url');
        }

        $this->reader->save($this->config, $settings);

        return $this->getIoWebhook();
    }
}
