<?php

namespace repositories\filesystem;

use Config;
use Models\Filesystem\FileInterface as FileInterface;
use Models\Filesystem\Image as Image;
use URL;

class DiskFileSystem implements FilesystemInterface
{
    protected $path;
    protected $url;

    public function __construct()
    {
        //----------------------------------
        // Create url and path

        $this->path = Config::get('app.filesystem.disk.path');
        $this->url = URL::to('/').$this->path;
    }

    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    public function findAllImages()
    {
        $images = [];
        $dir = opendir(public_path().$this->path);
        while (($currentFile = readdir($dir)) !== false) {
            if ($currentFile == '.' or $currentFile == '..' or $currentFile == '.DS_Store') {
                continue;
            }

            $image = new Image();
            $image->setTimezone($this->timezone);
            $image->parse($currentFile);
            array_push($images, $image);
        }
        closedir($dir);

        return $images;
    }

    public function getPathToFile(FileInterface $file)
    {
        return $this->url.$file->getPath();
    }

    public function getMetadata(FileInterface $file)
    {
        return $file->getMetadata();
    }
}
