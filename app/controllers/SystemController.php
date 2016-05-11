<?php namespace Controllers;

use View, Redirect, Input, Config, Response, Session, Auth;
use Repositories\ImageHandler\ImageHandlerInterface as ImageHandlerInterface;
use Repositories\ConfigReader\ConfigReaderInterface as ConfigReaderInterface;
use Repositories\Support\SupportInterface as SupportInterface;
use Repositories\System\OSXSystem as OSXSystem;
use Repositories\System\LinuxSystem as LinuxSystem;

class SystemController extends BaseController
{
    public function __construct(ImageHandlerInterface $imageHandler, 
        ConfigReaderInterface $reader,
        SupportInterface $support)
    {
        parent::__construct($imageHandler, $reader, $support);
        
        $this->imageHandler = $imageHandler;
        $this->reader = $reader;
        $this->support = $support;
        $this->config = Config::get("app.config");
        $this->user = Auth::user();
        
        $uname = strtolower(php_uname());
        if (strpos($uname, 'darwin') !== false)
        {
            $this->system = new OSXSystem();
        }
        else if (strpos($uname, 'linux') !== false)
        {
            $this->system = new LinuxSystem();
        }
    }
    
    /********************************************
     *  Show the settings page.
     */ 

    public function index()
    {
        $directory = $this->config;
        $settings = $this->reader->parse($directory)["instance"]["children"];
        $days = $this->imageHandler->getDays(5);
        $allDays = $this->imageHandler->getDays(-1);
        $numberOfImages = $this->imageHandler->getNumberOfImages();
        $articles = $this->support->getArticles();
        
        return View::make('system',
        [
            'days' => $days,
            'allDays' => $allDays,
            'numberOfImages' => $numberOfImages,
            'settings' => $settings,
            'system' => $this->system,
            'articles' => $articles,
            'isUpdateAvailable' => $this->isUpdateAvailable(),
        ]);
    }
    
    public function downloadConfiguration()
    {
        // Check which configuration directory to copy
        $configDirectory = '/data/machinery';
        $output = shell_exec("[ -d $configDirectory ] && echo 'true' || echo 'false'");
        if(trim($output) === "false")
        {
            $configDirectory = "/etc/opt/kerberosio";
        }

        $dir = "/data/";
        $output = shell_exec("[ -d $dir ] && echo true || echo false");
        if($output === true)
        {
            $dir = "/data/tmp";
            $output = shell_exec("mkdir -p $dir");
        }
        else
        {
            $dir = "/tmp";
        }
        
        $file = "$dir/kerberosio-configuration.tar.gz";
        $output = shell_exec("[ -f $file ] && echo true || echo false");
       
        if($output === "true")
        {
            $output = shell_exec("rm $file");
        }

        $output = shell_exec("cd $configDirectory && tar -zcvf $file config logs");
        
        return Response::download($file);
    }
    
    public function downloadImages()
    {
        $directory = $this->config;
        $settings = $this->reader->parse($directory)["instance"]["children"];
        
        $imageDirectory = rtrim($settings['io']['dropdown']['Disk']['children']['directory']['value'], '/');
        if(is_link($imageDirectory))
        {
            $imageDirectory = readlink($imageDirectory);
        }
        
        $dir = "/data/";
        $output = shell_exec("[ -d $dir ] && echo true || echo false");
        if($output === true)
        {
            $dir = "/data/tmp";
            $output = shell_exec("mkdir -p $dir");
        }
        else
        {
            $dir = "/tmp";
        }
        
        $file = "$dir/kerberosio-images.tar.gz";
        $output = shell_exec("[ -f $file ] && echo true || echo false");
       
        if($output === "true")
        {
            $output = shell_exec("rm $file");
        }

        $output = shell_exec("cd $imageDirectory && tar -zcvf $file .");
        
        return Response::download($file);
    }
    
    public function cleanImages()
    {
        $directory = $this->config;
        $settings = $this->reader->parse($directory)["instance"]["children"];
        
        // Clear session
        $key = $this->user->username . "_days";
        Session::forget($key);
        
        // Remove all images
        $imageDirectory = rtrim($settings['io']['dropdown']['Disk']['children']['directory']['value'], '/');
        if(is_link($imageDirectory))
        {
            $imageDirectory = readlink($imageDirectory);
        }
        $output = shell_exec("find $imageDirectory -type f -name '*' -print0 | xargs -0 rm;");

        return Response::json(["clean" => true]);
    }
    
    public function download()
    {
        $response = $this->system->download();
        return Response::json($response);
    }
    
    public function progress()
    {
        $response = $this->system->progress();
        return Response::json($response);
    }
    
    public function unzip()
    {
        $response = $this->system->unzip();
        return Response::json($response);
    }
    
    public function depack()
    {
        $response = $this->system->depack();
        return Response::json($response);
    }
    
    public function transfer()
    {
        $response = $this->system->transfer();
        return Response::json($response);
    }
    
    public function reboot()
    {
        $response = $this->system->reboot();
        return Response::json($response);
    }
    
    public function getVersions()
    {
        $versions = $this->system->getVersionsFromGithub();
        return Response::json($versions);
    }

    public function isStreamRunning()
    {
        $status = true;

        try
        {
            $fp = fsockopen('127.0.0.1', 8888, $errno, $errstr, 5);
            if(!$fp)
            {
                // port is closed or blocked
                $status = false;
            }
            else
            {
                // port is open and available
                fclose($fp);
            }
        }
        catch(\Exception $ex)
        {
            $status = false;
        }

        return Response::json(["status" => $status]);
    }
}