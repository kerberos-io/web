<?php namespace App\Http\Controllers;

use Config, View, Response, Validator;
use App\Http\Repositories\ImageHandler\ImageHandlerInterface as ImageHandlerInterface;
use App\Http\Repositories\ConfigReader\ConfigReaderInterface as ConfigReaderInterface;

class ImageController extends BaseController
{
    public function __construct(ImageHandlerInterface $imageHandler,
        ConfigReaderInterface $reader)
    {
        parent::__construct($imageHandler, $reader);
        $this->imageHandler = $imageHandler;
        $this->reader = $reader;
        $this->config = Config::get("app.config");
    }

    /***************************************
     *  Show the images of a specific date
     */

    public function index($selectedDay = "")
    {
        // ---------------------------------
        // If no day selected take last day

        if($selectedDay == "")
        {
            $selectedDay = $this->imageHandler->getDays(1)[0];
        }

        // --------------------------------------------------------------
        // Get the last hour of the selected day when an event occurred.

        $validator = Validator::make(['day' => $selectedDay], ['day' => 'date_format:d-m-Y']);
        if (!$validator->fails())
        {
            $lastHourOfDay = $this->imageHandler->getLastHourOfDay($selectedDay);
        }
        else
        {
            $lastHourOfDay = 0;
        }

        $directory = $this->config;
        $settings = $this->reader->parse($directory)["instance"]["children"];
        $isActive = ($settings["condition"]["dropdown"]["Enabled"]["children"]["active"]["value"] === "true") ? "none" : "block";

        // ----------------------------------------------------------------------
        // Get last x days from the imagehandler -> move to BaseController

        $days = $this->imageHandler->getDays(5);

        return View::make('image', [
            'isActive' => $isActive,
            'cameraName' => $settings['name']['value'],
            'days' => $days,
            'selectedDay' => $selectedDay,
            'lastHourOfDay' => $lastHourOfDay
        ]);
    }

    /*************************************
     *  Get all days
     */
    public function getDays()
    {
        $days = $this->imageHandler->getDays(-1);

        return Response::json($days);
    }

    /*************************************
     *  Get all regions
     */
    public function getRegions()
    {
        $numberOfRegions = 250;
        $regions = $this->imageHandler->getRegions($numberOfRegions);

        return Response::json($regions);
    }

    /*************************************
     *  Get the latest image that was taken.
     */

    public function getLatestImage()
    {
        return $this->imageHandler->getLatestImage();
    }

    /**********************************
     *  Get the latest sequence.
     *
     *   - these extra checks are needed when you're recording video.
     *   it's possible that while you're changing the region
     *   a video is recording. Therefore no image can be retrieved.
     */

    public function getLatestSequence()
    {
        $images = $this->imageHandler->getLatestSequence();

        $videosFound = false;
        for($i = 0; $i < count($images); $i++)
        {
            if($images[$i]['type'] === 'video')
            {
                $videosFound = true;
                break;
            }
        }

        if($videosFound)
        {
            for($i = count($images) - 1; $i >= 0; $i--)
            {
                $media = $images[$i];

                // We will use getID4 to check if media this.
                $getID3 = new \getID3;
	              $mediaInfo = $getID3->analyze($media['local_src']);

                if($media['type'] === 'image')
                {
                    array_pop($images);
                }
                elseif($media['type'] === 'video')
                {
                    if(array_key_exists('playtime_seconds', $mediaInfo) &&
                    $mediaInfo['playtime_seconds'])
                    {
                        break;
                    }
                    else // If a video but not valid, remove it!
                    {
                        array_pop($images);
                    }
                }
            }
        }

        return Response::json($images);
    }

    /******************************************
     *  Return output images as json.
     *      - page: one indexed.
     *      - images are returned in reversed order, most recent images first.
     */

    public function getImages($day, $take = 16, $page = 1)
    {
        $images = [];

        $validator = Validator::make(['day' => $day], ['day' => 'date_format:d-m-Y']);
        if (!$validator->fails())
        {
            $maxTimeBetweenTwoImagesInSeconds = 120;

            $images = $this->imageHandler->getImagesSequenceFromDay($day, $page, $maxTimeBetweenTwoImagesInSeconds);
        }

        return Response::json($images);
    }

    /************************************
     *  Return output images as json.
     *      - page: one indexed.
     *      - images are shown in ascending order, from a specific start time
     */
    public function getImagesFromStartTime($day, $take = 16, $page = 1, $time = 0)
    {
        $images = [];

        $validator = Validator::make(['day' => $day], ['day' => 'date_format:d-m-Y']);
        if (!$validator->fails())
        {
            $maxTimeBetweenTwoImagesInSeconds = 120;

            $images = $this->imageHandler->getImagesSequenceFromDayAndStartTime($day, $page,
                                                                               $time, $maxTimeBetweenTwoImagesInSeconds);
        }
        return Response::json($images);
    }

    /****************************************************
     *  Return images per hour for the last x days
     */
    public function getImagesPerHour($days = 3, $averageDays = 9)
    {
        $imagesPerHour = $this->imageHandler->getNumberOfImagesPerHourForLastDays($days, $averageDays);

        return Response::json($imagesPerHour);
    }

    /****************************************************
     *  Return images per hour for a specific day
     */
    public function getImagesPerHourForDay($day)
    {
        $validator = Validator::make(['day' => $day], ['day' => 'date_format:d-m-Y']);
        if (!$validator->fails())
        {
            $imagesPerHour = $this->imageHandler->countImagesPerHour($day)['total'];
        }

        return Response::json($imagesPerHour);
    }

    /************************************************
     *  Return images per day for the last x days
     */
    public function getImagesPerDay($days = 3, $averageDays = 9)
    {
        $imagesPerDay = $this->imageHandler->getNumberOfImagesPerDayForLastDays($days, $averageDays);

        return Response::json($imagesPerDay);
    }

    /**************************************************
     *  Return images per week day for the last x days
     */
    public function getAverageImagesPerWeekDay($numberOfWeeks = 1)
    {
        $imagesPerWeekDay = $this->imageHandler->getNumberOfImagesPerWeekDayPerInstance($numberOfWeeks);

        return Response::json($imagesPerWeekDay);
    }
}
