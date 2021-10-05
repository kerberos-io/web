<?php namespace App\Http\Repositories\Filesystem;

use Config, URL;
use App\Http\Models\Data\Heap as Heap;
use App\Http\Models\Filesystem\FileInterface as FileInterface;
use App\Http\Models\Filesystem\Image as Image;

class DiskFilesystem implements FilesystemInterface
{
    protected $path;
    protected $url;
    protected $system;

    public function __construct()
    {
        //----------------------------------
        // Create url and path

        $this->path = Config::get("app.filesystem.disk.path");
        $this->url = URL::to('/') . $this->path;
        $this->system = public_path() . $this->path;
    }

	public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    public function findAllImages()
    {
        $heap = new Heap;
        $dirpath = public_path() . '/' . $this->path;
        if (is_dir($dirpath)) {
            $dir = opendir($dirpath);
            while(($currentFile = readdir($dir)) !== false)
            {
                if($currentFile != '.' && $currentFile != '..')
                {
                    $heap->insert($currentFile);
                }
            }
            closedir($dir);
        }

        return $heap;
    }

    public function getPathToFile(FileInterface $file)
    {
        return $this->url . '/' . $file->getPath();
    }

    public function getSystemPathToFile(FileInterface $file)
    {
        return $this->system . '/' . $file->getPath();
    }

    public function getMetadata(FileInterface $file)
    {
        return $file->getMetadata();
    }
}
