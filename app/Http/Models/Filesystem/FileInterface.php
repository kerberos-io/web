<?php namespace App\Http\Models\Filesystem;

interface FileInterface
{
    /*************************
    *   Parse key into fields
    */
    public function parse($key);

    /********************
    *   Get path to file
    */
    public function getPath();
    public function getKey();

    /**********************************
    *   Get information array from file
    */
    public function setInformation($information);
    public function getInformation();
    public function getMetadata();

    /***************************************
    *   Get additional information from file
    */
    public function getOwner();
    public function getInstanceName();
    public function getChanges();
    public function getRegion();
    public function getToken();

    /*********************************
    *   Get date information from file
    */
    public function getTimestamp();
    public function getTime();
    public function getDate();
    public function getShortDate();
    public function getDayOfWeek();
}
