<?php namespace Repositories\Filesystem;

use Models\Filesystem\FileInterface as FileInterface;

interface FilesystemInterface
{
    /******************
    *   Set timezone
    */
    public function setTimezone($timezone);

    /*******************************
    *   Get all images on filesystem 
    */
    public function findAllImages();

    /********************************
    *  Get path to file on filesystem
    */
    public function getPathToFile(FileInterface $file);

    /*************************************
    *   Get metadata of file on filesystem 
    */
    public function getMetadata(FileInterface $file);
}