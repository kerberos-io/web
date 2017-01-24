<?php namespace Controllers;

use View, Response, Validator;
use Repositories\ImageHandler\ImageHandlerInterface as ImageHandlerInterface;
use Repositories\ConfigReader\ConfigReaderInterface as ConfigReaderInterface;

class ImageController extends BaseController
{
    public function __construct(ImageHandlerInterface $imageHandler, 
        ConfigReaderInterface $reader)
    {
        parent::__construct($imageHandler, $reader);
        $this->imageHandler = $imageHandler;
        $this->reader = $reader;
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
        
        // ----------------------------------------------------------------------
        // Get last x days from the imagehandler -> move to BaseController

        $days = $this->imageHandler->getDays(5);

        return View::make('image', [
            'days' => $days,
            'selectedDay' => $selectedDay,
            'lastHourOfDay' => $lastHourOfDay,
            'isUpdateAvailable' => $this->isUpdateAvailable()
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

    /********************************
     *  Get the latest sequence.
     */ 

    public function getLatestSequence()
    {
        $images = $this->imageHandler->getSecondLatestSequence();

        if(count($images) == 0)
        {
            $images = $this->imageHandler->getLatestSequence();
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