<?php namespace App\Http\Controllers;

use View, Redirect, Input, Config, Response, URL, Session;
use \Illuminate\Filesystem\Filesystem as Filesystem;
use App\Http\Models\Config\FileLoader as FileLoader;
use App\Http\Repositories\ImageHandler\ImageHandlerInterface as ImageHandlerInterface;
use App\Http\Repositories\ConfigReader\ConfigReaderInterface as ConfigReaderInterface;

class SettingsController extends BaseController
{
    public function __construct(ImageHandlerInterface $imageHandler,
        ConfigReaderInterface $reader)
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

        $this->fileLoader = new FileLoader(new Filesystem(), config_path());
    }

    /********************************************
     *  Show the settings page.
     */

    public function index()
    {
        $directory = $this->config;
        $settings = $this->reader->parse($directory)["instance"]["children"];
        $isActive = ($settings["condition"]["dropdown"]["Enabled"]["children"]["active"]["value"] === "true") ? "none" : "block";

        $days = $this->imageHandler->getDays(5);

        $kios = null;
        if($this->isKios())
        {
            $kios = [
                'autoremoval' => $this->getAutoRemoval(),
                'forcenetwork' => $this->getForceNetwork(),
            ];
        }

        return View::make('settings',
        [
            'isActive' => $isActive,
            'cameraName' => $settings['name']['value'],
            'days' => $days,
            'settings' => $settings,
            'kerberos' => $this->kerberos,
            'kios' => $kios
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

        $properties = array_merge(Session::get('kerberos', []), $properties);
        Session::put('kerberos', $properties);

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

        $properties = array_merge(Session::get('kerberos', []), $properties);
        Session::put('kerberos', $properties);

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

        // ------------------------------------
        // Get username and password of stream

        $username = $this->getPiece("stream.xml", ["Mjpg","username"])->__toString();
        $password = $this->getPiece("stream.xml", ["Mjpg","password"])->__toString();
        $authentication = "";
        if($username != "" && $password != "")
        {
            // Disabled in Chrome 59 and other browsers.
            // Need to find a work a round..

            //$authentication = $username . ":" . $password . "@";

        }

        $protocol = 'http://';
        $originalUrl =  URL::to('/');
        if(explode('://', $originalUrl)[0] === "https")
        {
            $protocol = 'https://';
        }

        if(trim($output) === "true")
        {
            $url = $protocol . $authentication . str_replace($protocol, '', URL::to('/'))  . '/stream';
            $port = '8889';
        }
        else
        {
            $instance = explode(',', $this->getPiece("stream.xml", ["Mjpg","streamPort"])->__toString());
            $url = parse_url(URL::to('/'), PHP_URL_HOST);
            $port = $instance[0];
            $url = $protocol . $authentication . $url . ':' . $port;
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

    // -------------------------------------------
    // Duplicate functions with OSsystem.php class,
    // TODO: refactor these methods.

    public function getBoard()
    {
        $cmd = 'cat /etc/board';
        $board = shell_exec($cmd);
        return trim($board);
    }

    public function isKios()
    {
        return ($this->getBoard()!='');
    }

    //
    // -------------------------

    public function getForceNetwork()
    {
        $cmd = 'cat /data/etc/watch.conf | grep "netwatch_enable"';
        $forcenetwork = shell_exec($cmd);

        if($forcenetwork && $forcenetwork !== '')
        {
            $parameter = explode('=', $forcenetwork);
            $active = (str_replace("\n", '', $parameter[1]) === 'yes');
        }

        return $active;
    }

    public function updateForceNetwork()
    {
        $active = (Input::get('active') === "true") ? "yes" : "no";
        $currentState = ($this->getForceNetwork()) ? "yes" : "no";

        if($active !== $currentState)
        {
            $old = "netwatch_enable\=$currentState";
            $new = "netwatch_enable\=$active";
            shell_exec("sed -i 's/$old/$new/g' /data/etc/watch.conf");
            return ['active' => $active];
        }

        return ['active' => $currentState];
    }

    public function getAutoRemoval()
    {
        $cmd = 'cat /data/etc/watch.conf | grep "autoremoval"';
        $autoremoval = shell_exec($cmd);

        if($autoremoval && $autoremoval !== '')
        {
            $parameter = explode('=', $autoremoval);
            $active = (str_replace("\n", '', $parameter[1]) === 'yes');
        }

        return $active;
    }

    public function updateAutoRemoval()
    {
      $active = (Input::get('active') === "true") ? "yes" : "no";
      $currentState = ($this->getAutoRemoval()) ? "yes" : "no";

      if($active !== $currentState)
      {
          $old = "autoremoval\=$currentState";
          $new = "autoremoval\=$active";
          shell_exec("sed -i 's/$old/$new/g' /data/etc/watch.conf");
          return ['active' => $active];
      }

      return ['active' => $currentState];
    }
}
