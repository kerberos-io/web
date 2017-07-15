<?php namespace App\Http\Models\Filesystem;

use Config, Auth;
use Carbon\Carbon as Carbon;

class Image implements FileInterface
{
    private $information;
    private $timezone;

    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    public function parse($key)
    {
        // --------------------------------
        // Get information from image name

        $this->information = [];

        $this->information['key'] = $key;

        $path = explode('/', $key);
        $this->information['user'] = $path[0];
        $path = end($path);
        $this->information['path'] = $path;

        // --------------------------------
        // Formatting information of image

        $fileFormat = Config::get('app.filesystem.fileFormat');
        $fileFormat = explode('.', $fileFormat)[0]; // e.g. fileFormat = "timestamp_name_region_numberOfChanges_token.jpg";
        $fileFormat = explode('_', $fileFormat); // e.g. fileFormat = "timestamp_name_region_numberOfChanges_token";

        // -----------------------------
        // Split path into logical parts

        $image = explode('.', $path)[0]; // e.g. path = "147541554_.._.._1337.jpg";
        $information = explode('_', $image); // e.g. image = "147541554_.._.._1337"

        // --------------------------------
        // Fill associative array with data

        for($i = 0; $i < count($fileFormat) && $i < count($information); $i++)
        {
            $this->information[$fileFormat[$i]] = $information[$i];
        }

        // --------------------------------------------------
        // Calculate different time/date formats with Carbon

        $this->information['timestamp'] = intval($this->information['timestamp']);
        $this->setTimeFormats($this->information['timestamp']);
    }

    public function getPath()
    {
        return $this->information['path'];
    }

    public function getKey()
    {
        return $this->information['key'];
    }

    public function setInformation($information)
    {
        $this->information = $information;
    }

    public function getInformation()
    {
        return $this->information;
    }

    public function getMetadata()
    {
        return array_except($this->information, ['carbon', 'path', 'updated_at', 'created_at']);
    }

    public function getOwner()
    {
        return $this->information['user'];
    }

    public function getInstanceName()
    {
        return $this->information['instanceName'];
    }

    public function getChanges()
    {
        if(array_key_exists('numberOfChanges', $this->information))
        {
            return $this->information['numberOfChanges'];
        }

        return 0;
    }

    public function getRegion()
    {
        if(array_key_exists('regionCoordinates', $this->information))
        {
            return $this->information['regionCoordinates'];
        }

        return "";
    }

    public function getTimestamp()
    {
        return $this->information['timestamp'];
    }

    public function setTimeFormats($timestamp)
    {
        $carbon = Carbon::createFromTimeStamp($timestamp);
        $carbon->setTimezone($this->timezone);

        $this->information['carbon'] = [
            'timezone' => $this->timezone,
            'time' => $carbon->format('H:i:s'), // e.g. 16:45:16
            'date' => $carbon->format('jS \\of F Y'), // e.g. 24th of February 2015
            'short-date' => $carbon->format('d-m-Y'), // e.g. 24-02-2015
            'day-of-week' => $carbon->dayOfWeek, // e.g. 1-7
        ];
    }

    public function getTimeFormats()
    {
        return $this->information['carbon'];
    }

    public function getTime()
    {
        return $this->information['carbon']['time'];
    }

    public function getDate()
    {
        return $this->information['carbon']['date'];
    }

    public function getShortDate()
    {
        return $this->information['carbon']['short-date'];
    }

    public function getDayOfWeek()
    {
        return $this->information['carbon']['day-of-week'];
    }

    public function getToken()
    {
        return $this->information['token'];
    }

    // *****************************************************
    // This is to store the signed part for secured images
    // Currently this is used for the Amazon S3 fileystem repository

    public function setSigned($signedPart)
    {
        $this->information['signed'] = $signedPart;
    }

    public function getSigned()
    {
        return $this->information['signed'];
    }
}
