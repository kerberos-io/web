<?php namespace Repositories\Filesystem;

use Config, URL;
use Models\Data\Heap as Heap;
use Models\Filesystem\FileInterface as FileInterface;
use Models\Filesystem\Image as Image;

class DiskFilesystem implements FilesystemInterface
{
    protected $path;
    protected $url;

    public function __construct()
    {
        //----------------------------------
        // Create url and path
        
        $this->path = Config::get("app.filesystem.disk.path");
        $this->url = URL::to('/') . $this->path;
    }

	public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    public function findAllImages()
    {
        $heap = new Heap;

        $dir = opendir(public_path() . $this->path);
        while(($currentFile = readdir($dir)) !== false)
        {
            if($currentFile != '.' || $currentFile != '..')
            {
                $heap->insert($currentFile);
            }
        }

        closedir($dir);
        return $heap;
    }

    public function getPathToFile(FileInterface $file)
    {
        return $this->url . $file->getPath();
    }

    public function getMetadata(FileInterface $file)
    {
        return $file->getMetadata();
    }
}