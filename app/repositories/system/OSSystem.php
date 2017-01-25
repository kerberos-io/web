<?php namespace Repositories\System;

use Config, Input;

class OSSystem implements SystemInterface
{
    use \Traits\GetVersions;
        
    private $upgradeDir = '/data/.firmware_update'; // '/Users/cedricverst/Desktop/kios';
    private $bootDir = '/boot';
    
    public function __construct(){}

    public function initialize()
    {
        $linfo = new \Linfo\Linfo();
        $this->parser = $linfo->getParser();
    }

    public function getShortLog()
    {
        $file = '/etc/opt/kerberosio/logs/log.stash';
        $content = file($file);
        $content = array_slice($content, -15);
        $content = implode('', $content);
        return $content;
    }

    public function getLog()
    {
        $file = '/etc/opt/kerberosio/logs/log.stash';
        //$content = file_get_contents($file);
        $content = shell_exec('exec tail -n200 ' . $file);
        return $content;
    }
    
    public function getWebVersion()
    {
        return Config::get('app.version');
    }
    
    public function getMachineryVersion()
    {
        $cmd = "/usr/bin/kerberosio -v";
        $version = shell_exec($cmd);
        return ltrim($version, 'v');
    }
    public function isMachineryRunning()
    {
        $cmd = "ps -a | grep kerberosio";
        $processes = shell_exec($cmd);
        if(strlen($processes) == 0)
        {
            // Fix if running on Raspbian..
            $cmd = 'service kerberosio status | grep "active (running)"';
            $processes = shell_exec($cmd);
            return (strlen($processes) > 0);
        }
        else
        {
            return true;
        }
    }
    
    public function getOS()
    {
        return $this->parser->getOS();
    }
    
    public function getKernel()
    {
        return $this->parser->getKernel();
    }
    
    public function getModel()
    {
        $model = $this->parser->getModel();
        return $model;
    }
    
    public function getCPUs()
    {
        $cpus = $this->parser->getCPU();
        return $cpus;
    }
    
    public function getCPUArchitecture()
    {
        $cpusArchitecture = $this->parser->getCPUArchitecture();
        return $cpusArchitecture;
    }
    
    public function getLoad()
    {
        $load = $this->parser->getLoad();
        return $load;
    }
    
    public function getAverageLoad()
    {
        $load = $this->parser->getLoad();
        $average = ($load['now'] + $load['5min'] + $load['15min'])/3;
        return round($average, 2);
    }
    
    public function getUptime()
    {
        $uptime = $this->parser->getUpTime();
        return $uptime;
    }
    
    public function getProcessStats()
    {
        $processStats = $this->parser->getProcessStats();
        return $processStats;
    }
    
    public function getHostName()
    {
        $hostName = $this->parser->getHostName();
        return $hostName;
    }
    
    public function getAccessedIP()
    {
        $ip = $this->parser->getAccessedIP();
        return $ip;
    }
    
    public function getNet()
    {
        $nets = $this->parser->getNet();
        
        $filtered = [
            'networks' => []
        ];

        foreach($nets as $key => &$interface)
        {
            if($interface['recieved']['bytes'] > 0 || $interface['sent']['bytes'] > 0)
            {
                $interface['name'] = $key;
                $interface['text'] = [];
                $interface['text']['recieved'] = $this->toReadableSize($interface['recieved']['bytes']);
                $interface['text']['sent'] = $this->toReadableSize($interface['sent']['bytes']);
                
                array_push($filtered['networks'], $interface);
            }
        }
                
        return $filtered;
    }
    
    public function getRam()
    {
        $ram = $this->parser->getRam();
        return $ram;
    }
    
    public function getHD()
    {
        $hd = $this->parser->getHD();
        
        foreach($hd as &$disk)
        {
            $disk['text'] = [];
            $disk['text']['size'] = $this->toReadableSize($disk['size']);
        }
        
        return $hd;
    }
    
    public function getMounts()
    {
        $mounts = $this->parser->getMounts();
        
        $filtered = [
            'disks' => []
        ];
        foreach($mounts as &$mount)
        {
            if($mount['used'] > 0 &&
              !array_key_exists($mount['device'], $filtered)
            )
            {
                $mount['text'] = [];
                $mount['text']['used'] = $this->toReadableSize($mount['used']);
                $mount['text']['free'] = $this->toReadableSize($mount['free']);
                $mount['text']['size'] = $this->toReadableSize($mount['size']);
                $mount['isFull'] = ($mount['used_percent'] > 75);
                $mount['isAlmostFull'] = ($mount['used_percent'] > 50);

                array_push($filtered['disks'], $mount);
            }
        }
        
        return $filtered;
    }
    
    public function diskAlmostFull()
    {
        $mounts = $this->getMounts();
        
        $percentage = 0;
        foreach($mounts as &$mount)
        {
            $percentage += $mount['used_percent'];
        }
        $percentage /= count($mounts);
        
        return ($percentage > 75) ? true : false;
    }
    
    public function getFreeSpace()
    {
        $hd = $this->getHD();
        return $hd;
    }
    
    public function getPhpVersion()
    {
        $php = $this->parser->getPhpVersion();
        return $php;
    }
    
    public function getWebserver()
    {
        $webserver = $this->parser->getWebService();
        return $webserver;
    }
        
    public function toReadableSize($bytes)
    {
        if($bytes > 999)
        {
            $kb = $bytes/1024;
            if($kb > 999)
            {
                $mb = $kb/1024;
                if($mb > 999)
                {
                    $gb = $mb/1024;
                    if($gb > 999)
                    {
                        $tb = $gb/1024;
                        return round($tb,2) . " TB";
                    }
                    else
                    {
                        return round($gb,2) . " GB";
                    }
                }
                else
                {
                    return round($mb,2) . " MB";
                }
            }
            else
            {
                return round($kb,2) . " KB";
            }
        }
        else
        {
            return $bytes . " bytes";   
        }
    }
    
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
    
    public function download()
    {
        $version = Input::get('version');
        $url = Input::get('download');
 
        // create upgrade dir 
        $upgradeDir = $this->upgradeDir;
        $cmd = "mkdir -p $upgradeDir 2>&1";
        $output = shell_exec($cmd);
        
        // remove existing file
        $upgradeDir = $this->upgradeDir;
        $name = "$upgradeDir/kios.img.gz";
        $cmd = "rm $name > /dev/null 2>/dev/null &";
        $output = shell_exec($cmd);

        // get current release file
        // wget https://github.com/..325.img.gz -O /data/.firmware_update/kios.img.gz
        $cmd = "wget " . $url . " --no-check-certificate -O $name > /dev/null 2>/dev/null &";
        $output = shell_exec($cmd);

        return true;
    }
    
    public function progress()
    {
        $completeSize = Input::get('size');

        // Check existing file
        $upgradeDir = $this->upgradeDir;
        $name = "$upgradeDir/kios.img.gz";

        // for osx
        //$cmd = "stat -f%z $name";
        // for linux
        $cmd = "stat -c%s $name";
        $size = (int) shell_exec($cmd);
        
        $progress = round($size / $completeSize * 100, 0);
        
        return ['progress' => $progress];
    }
    
    public function unzip()
    {
        $upgradeDir = $this->upgradeDir;

        $cmd = "rm $upgradeDir/kios.img";
        $output = shell_exec($cmd);

        $cmd = "/bin/gunzip $upgradeDir/kios.img.gz 2>&1";
        $output = shell_exec($cmd);
        
        return true;
    }
    
    public function depack()
    {
        $upgradeDir = $this->upgradeDir;

        $cmd = "/sbin/fdisk -l $upgradeDir/kios.img 2>&1";
        $output = str_replace('  ', ' ', shell_exec($cmd));
        preg_match("/kios.img1 \* (.*?) W95/", $output, $matchesBoot);
        $matchesBoot = explode(' ', trim($matchesBoot[1]));

        preg_match("/kios.img2 (.*?) Linux/", $output, $matchesRoot);
        $matchesRoot = explode(' ', trim($matchesRoot[1]));

        if(count($matchesBoot) > 0 && count($matchesRoot) > 0)
        {
            $bootStart = (int) $matchesBoot[0];
            $bootEnd = (int) $matchesBoot[1];
            $bootSkip = $bootStart / 4;
            $bootCount = ($bootEnd - $bootStart + 1)/4;

            $rootStart = (int) $matchesRoot[0];
            $rootEnd = (int) $matchesRoot[1];
            $rootSkip = $rootStart / 4;
            $rootCount = ($rootEnd - $rootStart + 1)/4;

            // calculate start and end..
            ///bin/dd if=kios.img of=boot.img bs=2048 skip=512 count=10240
            $cmd = "/bin/dd if=$upgradeDir/kios.img of=$upgradeDir/boot.img bs=2048 skip=$bootSkip count=$bootCount";
            $output = shell_exec($cmd);
            
            ///bin/dd if=kios.img of=root.img bs=2048 skip=10753 count=140800
            $cmd = "/bin/dd if=$upgradeDir/kios.img of=$upgradeDir/root.img bs=2048 skip=$rootSkip count=$rootCount";
            $output = shell_exec($cmd);

            return true;
        }

        return false;
    }
    
    public function transfer()
    {
        $bootDir = $this->bootDir;
        $upgradeDir = $this->upgradeDir;
        
        // copy files
        $cmd = "cp $bootDir/config.txt /data/tmp/config.txt";
        $output = shell_exec($cmd);
        $cmd = "cp $bootDir/static_ip.conf /data/tmp/static_ip.conf";
        $output = shell_exec($cmd);
        $cmd = "cp $bootDir/wireless.conf /data/tmp/wireless.conf";
        $output = shell_exec($cmd);
        
        // mount boot
        $cmd = "/bin/umount $bootDir";
        $output = shell_exec($cmd);
        $cmd = "/bin/dd if=$upgradeDir/boot.img of=/dev/mmcblk0p1 bs=1M";
        $output = shell_exec($cmd);
        $cmd = "/bin/mount -o rw /dev/mmcblk0p1 $bootDir";
        $output = shell_exec($cmd);
        
        // revert files
        $cmd = "cp /data/tmp/config.txt $bootDir/config.txt";
        $output = shell_exec($cmd);
        $cmd = "cp /data/tmp/static_ip.conf $bootDir/static_ip.conf";
        $output = shell_exec($cmd);
        $cmd = "cp /data/tmp/wireless.conf $bootDir/wireless.conf";
        $output = shell_exec($cmd);
        
        return true;
    }
    
    public function reboot()
    {
        $bootDir = $this->bootDir;
        $upgradeDir = $this->upgradeDir;
        
        // rm boot img
        $cmd = "rm $upgradeDir/boot.img";
        $output = shell_exec($cmd);
        
        // append config file
        $cmd = "printf '\n%s' 'initramfs fwupdater.gz' >> $bootDir/config.txt"; // append to /boot/config.txt
        $output = shell_exec($cmd);
        
        // reboot
        $cmd = 'reboot';
        $output = shell_exec($cmd);
        
        return true;
    }
    
    public function rebooting()
    {        
        // reboot
        $cmd = 'reboot';
        $output = shell_exec($cmd);
        
        return true;
    }
    
    public function shuttingdown()
    {        
        // reboot
        $cmd = 'halt';
        $output = shell_exec($cmd);
        
        return true;
    }
}