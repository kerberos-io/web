<?php namespace App\Http\Controllers;

use View, Redirect, Input, Config, Response, Session, Auth, AWS;
use App\Http\Repositories\ImageHandler\ImageHandlerInterface as ImageHandlerInterface;
use App\Http\Repositories\ConfigReader\ConfigReaderInterface as ConfigReaderInterface;
use App\Http\Repositories\Support\SupportInterface as SupportInterface;
use App\Http\Repositories\System\OSXSystem as OSXSystem;
use App\Http\Repositories\System\LinuxSystem as LinuxSystem;

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
        $isActive = ($settings["condition"]["dropdown"]["Enabled"]["children"]["active"]["value"] === "true") ? "none" : "block";

        $days = $this->imageHandler->getDays(5);
        $insideDocker = (trim(shell_exec("[ -f /.dockerenv ] && echo true || echo false")) === 'true');

        return View::make('system',
        [
            'isActive' => $isActive,
            'cameraName' => $settings['name']['value'],
            'days' => $days
        ]);
    }

    public function getOS()
    {
        $this->system->initialize();

        return [
            'system' => $this->system,
            'uptime' => $this->system->getUptime()['text'],
            'board' => $this->system->getBoard(),
            'model' => $this->system->getModel(),
            'os' => $this->system->getOS(),
            'kernel' => $this->system->getKernel(),
            'hostname' => $this->system->getHostName(),
            'kernel' => $this->system->getKernel(),
            'numberOfCPU' => count($this->system->getCPUs()),
            'cpu' => $this->system->getCPUs(),
            'architecture' => $this->system->getCPUArchitecture(),
            'cpuLoad' => $this->system->getAverageLoad(),
            'numberOfMounts' => count($this->system->getMounts()),
            'mounts' => $this->system->getMounts(),
            'network' => $this->system->getNet(),
            'diskAlmostFull' => $this->system->diskAlmostFull()
        ];
    }

    public function getKerberos()
    {
        $days = $this->imageHandler->getDays(-1);

        return [
            'insideDocker' => (trim(shell_exec("[ -f /.dockerenv ] && echo true || echo false")) === 'true'),
            'days' =>  $days,
            'numberOfDays' => count($days),
            'numberOfImages' => $this->imageHandler->getNumberOfImages(),
            'webVersion' => $this->system->getWebVersion(),
            'machineryVersion' => $this->system->getMachineryVersion(),
            'isMachineryRunning' => $this->system->isMachineryRunning(),
            'shortLog' => $this->system->getShortLog(),
            'log' => $this->system->getLog()
        ];
    }

    public function getKiOS()
    {
        return [
            'isKios' => $this->system->isKios(),
            'board' => $this->system->getBoard(),
            'version' => $this->system->getCurrentVersion()
        ];
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

    public function rebooting()
    {
        $response = $this->system->rebooting();
        return Response::json($response);
    }

    public function shuttingdown()
    {
        $response = $this->system->shuttingdown();
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

        $directory = $this->config;
        $settings = $this->reader->parse($directory)["instance"]["children"];
        $port = $settings['stream']['dropdown']['Mjpg']['children']['streamPort']['value'];

        try
        {
            $fp = fsockopen('127.0.0.1', $port, $errno, $errstr, 5);
            if(!$fp)
            {
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

        // -----------------------
        // Work-a-round for docker

        if(!$status)
        {
            try
            {
                $fp = fsockopen('machinery', $port, $errno, $errstr, 5);
                if(!$fp)
                {
                    $status = false;
                }
                else
                {
                    // port is open and available
                    $status = true;
                    fclose($fp);
                }
            }
            catch(\Exception $ex)
            {
                $status = false;
            }
        }

        return Response::json(["status" => $status]);
    }

    public function checkCloud()
    {
        $input = Input::all();

        putenv('AWS_ACCESS_KEY_ID=' . $input["public"]);
        putenv('AWS_SECRET_ACCESS_KEY=' . $input["secret"]);
        putenv('AWS_REGION=eu-west-1');

        $s3 = AWS::createClient('s3');

        try {
          $s3->putObject([
            'Bucket'     => $input['bucket'],
            'Key'        => $input['folder'] . '/test_connection.txt',
            'Body'   => 'Hello this is a test :F!'
          ]);
          return Response::json(["status" => 200]);
        }
        catch(\Aws\S3\Exception\S3Exception $ex)
        {
            return $ex;
            return Response::json(["status" => 404]);
        }

        return Response::json(["status" => 404]);
    }
}
