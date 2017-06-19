<?php namespace App\Http\Repositories\ConfigReader;

interface ConfigReaderInterface
{
    /***************************
     *  Read settings from file
     */
    public function read($file);
    public function parse($file);

    /*********************************
     *  Save config files in directory
     */
    public function save($directory, $settings);

    /***********************************
     *  Get all configs from a directory
     */
    public function getConfigs($directory);
}
