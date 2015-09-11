<?php namespace Repositories\ImageHandler;

use Log;
use URL, Session, Config, Auth;
use Carbon\Carbon as Carbon;

use Repositories\Filesystem\FilesystemInterface as FilesystemInterface;
use Repositories\Date\DateInterface as DateInterface;
use Repositories\ConfigReader\ConfigReaderInterface as ConfigReaderInterface;
use Models\Filesystem\Image as Image;
use Models\Cache\Cache as Cache;

class ImageFilesystemHandler implements ImageHandlerInterface
{ 
    public function __construct(ConfigReaderInterface $reader,
                                FilesystemInterface $filesystem, DateInterface $date)
    {
        $this->cache = new Cache(Config::get('session.lifetime'));
        $this->user = Auth::user();

        $this->reader = $reader;
        $this->config = Config::get("app.config");
        $settings = $this->reader->read($this->config . '/config.xml');

        if(count($settings) > 0)
        {
            $timezone = $settings->instance->timezone;
            $timezone = str_replace("-", "/", $timezone);
            $timezone = str_replace("$", "_", $timezone);
        }
        else
        {
            $timezone = Config::get('app.timezone');
        }

        $this->date = $date;
        $this->date->timezone = $timezone;

        $this->filesystem = $filesystem;
        $this->filesystem->setTimezone($timezone);
    }
    
    public function getFileFormat()
    {
        $fileFormat = Config::get('app.filesystem.fileFormat');
        $fileFormat = explode('.', $fileFormat)[0]; // e.g. fileFormat = "timestamp_name_region_numberOfChanges_token.jpg";
        $fileFormat = explode('_', $fileFormat); // e.g. fileFormat = "timestamp_name_region_numberOfChanges_token";
        
        return $fileFormat;
    }
    
    public function getIndexOfTimestampFromFileFormat()
    {
        $fileFormat = $this->getFileFormat();
        
        $i = 0;
        while($i < count($fileFormat) && $fileFormat[$i] != 'timestamp')
        {
            $i++;
        }
        
        return $i;
    }
    
    public function getIndexOfInstanceNameFromFileFormat()
    {
        $fileFormat = $this->getFileFormat();
        
        $i = 0;
        while($i < count($fileFormat) && $fileFormat[$i] != 'instanceName')
        {
            $i++;
        }
        
        return $i;
    }
    
    public function getImagesFromFilesystem()
    {
        $heap = $this->filesystem->findAllImages();

        return $heap;
    }
    
    public function getLatestImage()
    {
        $latestSequence = $this->getLatestSequence();

        if(count($latestSequence)>0)
        {
            return $latestSequence[count($latestSequence)-1]["src"];
        }
        
        return "";
    }

    public function getLatestSequence()
    {
        $days = $this->getDays(1);

        if(count($days) > 0)
        {
            $day = $days[0];
            return $this->getImagesSequenceFromDay($day, 1, 120);
        }

        return [];
    }

    public function getLastHourOfDay($day)
    {
        $hours = $this->countImagesPerHour($day)['total'];

        $i = 23;
        while($i > 0 && $hours[$i] == 0)
        {
            $i--;
        }
                
        return $i;
    }

    public function getDays($numberOfDays)
    {
        // -------------------------------------
        // Cache images directory for x seconds

        $key = $this->user->username . "_days";

        $days = $this->cache->storeAndGet($key, function()
        {
            $heap = $this->getImagesFromFilesystem();
            $index = $this->getIndexOfTimestampFromFileFormat();
            
            $firstDay = $heap->current();
            $timestamp = intval(explode('_', $firstDay)[$index]);
            $carbon = Carbon::createFromTimeStamp($timestamp);
            $carbon->setTimezone($this->date->timezone);
            $day = $carbon->format('d-m-Y');
            $startTimestamp = $this->date->dateToTimestamp($day);

            $days = [];
            $restCheck = -1;
            while($heap->valid())
            {
                $timestamp = explode('_', $heap->current())[$index];
                $rest = intval(($timestamp - $startTimestamp) / 86400);

                if($restCheck != $rest)
                {
                    $restCheck = $rest;
                    array_push($days, $carbon->addDays($rest)->format('d-m-Y'));
                    $carbon->subDays($rest);
                }

                $heap->next();
            }
            
            return $days;
        });
        
        if($numberOfDays > 0)
        {
            return array_slice($days, 0, $numberOfDays);
        }
        else
        {
            return $days;
        }
    }

    public function getImages()
    {
        $imagesTemp = $this->getImagesFromFilesystem();

        $images = [];
        foreach(array_keys($imagesTemp) as $day)
        {
            foreach($imagesTemp[$day]['images'] as $image)
            {
                array_push($images, $image);
            }
        }
        
        return $images;
    }

    /************************************************
     *  Get a sequence of images from a specific day
     */
    public function getImagesSequenceFromDay($day, $page, $maximumTimeBetween)
    {
        if(!in_array($day, $this->getDays(-1)))
        {
            return [];
        }

        $startTimestamp = $this->date->dateToTimestamp($day);
        $endTimestamp = $this->date->nextDayToTimestamp($day);

        $imagesTemp = [];

        $heap = $this->getImagesFromFilesystem();
        $index = $this->getIndexOfTimestampFromFileFormat();
        
        // ---------------------------------------------
        // Iterate while timestamp is not in current day

        while($heap->valid())
        {
            $timestamp = intval(explode('_', $heap->current())[$index]);

            if($timestamp <= $endTimestamp)
            {
                break;
            }

            $heap->next();
        }

        while($heap->valid())
        {
            $timestamp = intval(explode('_', $heap->current())[$index]);

            if($timestamp < $startTimestamp)
            {
                break;
            }

            array_push($imagesTemp, ['timestamp' => $timestamp, 'path' => $heap->current()]);
            
            $heap->next();
        }
            
        // ---------------------------
        // Paging images in a sequence
        
        $imagesTemp = array_reverse($imagesTemp);
        $lower = count($imagesTemp)-1;
        $upper;
        
        // -----------------
        // If only one image

        if($lower == 0 && $page == 1)
        {
            $upper = 1;
        }
        else
        {
            $i = $page;
            for($i; $i > 0 && $lower > 0; $i--)
            {
                if($i < $page) $lower--;
                $upper = $lower;
                $current = $imagesTemp[$lower]['timestamp'];
                if($lower >= 1)
                {
                    $previous = $imagesTemp[$lower-1]['timestamp'];

                    // ----------------------------------------------------------
                    // if no sequence is found, only one image has to be selected
                    // and we shift to the next sequence

                    if($current - $previous <= $maximumTimeBetween) 
                    {
                        while($lower > 1 && $current - $previous <= $maximumTimeBetween)
                        {
                            $lower--;
                            $current = $previous;
                            $previous = $imagesTemp[$lower-1]['timestamp'];
                        }
                    }
                }
            }
            if($i > 0)
            {
                $lower = $upper = 0;
            }
            else
            {
                $upper++;
                if($current - $previous <= $maximumTimeBetween)
                {
                    $lower--;
                }
            }
        }

        $images = [];

        // ------------------------------------------
        // Filter images that belong to selected page

        foreach($imagesTemp as $key => $image)
        {
            if($key >= $lower && $key < $upper)
            {
                $path = $image['path'];

                $image = new Image;
                $image->setTimezone($this->date->timezone);
                $image->parse($path);

                array_push($images, [
                    'time' => $image->getTime(),
                    'src' => $this->filesystem->getPathToFile($image),
                    'metadata' => $this->filesystem->getMetadata($image),
                ]);
            }
        }

        return $images;
    }

    public function getImagesSequenceFromDayAndStartTime($day, $page, $starttime, $maximumTimeBetween)
    {
        if(!in_array($day, $this->getDays(-1)))
        {
            return [];
        }

        // --------------------------------------------------------------------
        // Convert starttime to timestamp (= day + starttime * seconds in hour)

        $startTimestamp = $this->date->dateTimeToTimestamp($day, $starttime);

        // ------------------------------------
        // Calculate timestamp of the day after

        $endTimestamp = $this->date->nextDayToTimestamp($day);

        $imagesTemp = [];
        $heap = $this->getImagesFromFilesystem();
        $index = $this->getIndexOfTimestampFromFileFormat();
        
        // ---------------------------------------------
        // Iterate while timestamp is not in current day

        while($heap->valid())
        {
            $timestamp = intval(explode('_', $heap->current())[$index]);

            if($timestamp <= $endTimestamp)
            {
                break;
            }

            $heap->next();
        }

        while($heap->valid())
        {
            $timestamp = intval(explode('_', $heap->current())[$index]);

            if($timestamp < $startTimestamp)
            {
                break;
            }

            array_push($imagesTemp, ['timestamp' => $timestamp, 'path' => $heap->current()]);

            $heap->next();
        }
        
        // -------------
        // Sequence images
        
        $imagesTemp = array_reverse($imagesTemp);
        $imagesTemp = $this->getSequence($imagesTemp, $page, $maximumTimeBetween);

        $images = [];
        foreach($imagesTemp as $image)
        {
            $path = $image['path'];
            
            $image = new Image;
            $image->setTimezone($this->date->timezone);
            $image->parse($path);
            
            array_push($images, [
                'time' => $image->getTime(),
                'src' => $this->filesystem->getPathToFile($image),
                'metadata' => $this->filesystem->getMetadata($image),
            ]);
        }
        return $images;
    }

    public function getSequence($images, $page, $maximumTimeBetween)
    {
        $n = count($images);

        if($n <= 1)
        {
            if($page == 1)
            {
                return $images;
            }
            elseif($page > 1)
            {
                return [];
            }
        }
        else
        {
            $i = 0; // page iterator
            $pointer = 1; // pointer to go through sequence

            $start = 0; // start position of sequence
            $end = 0; // end position of sequence

            while($i < $page && $pointer < $n)
            {
                $previous = $images[$pointer-1]['timestamp'];
                $current = $images[$pointer]['timestamp'];

                while($current - $previous <= $maximumTimeBetween && $pointer < $n)
                {
                    $pointer++;

                    if($pointer < $n)
                    {
                        $previous = $current;
                        $current = $images[$pointer]['timestamp'];
                    }
                }

                $start = $end;
                $end = $pointer;
                $i++;
                $pointer++;
            }

            if($i == $page-1 && ($pointer - 1) < $n)
            {
                $previous = $images[$pointer - 2]['timestamp'];
                $current = $images[$pointer - 1]['timestamp'];

                if($current - $previous > $maximumTimeBetween)
                {
                    $start = $pointer - 1;
                    $end = $pointer;
                }
            }
            else if($i < $page)
            {
                return [];
            }
            
            $images = array_where($images, function($key, $value) use ($start, $end, $images)
            {
                return ($key >= $start && $key < $end);
            });

            return $images;
        }
    }

    public function getNumberOfImagesPerHourForLastDays($numberOfDays, $averageDays)
    {
        $days = $this->getDays($numberOfDays);

        $statistics = [
            "days" => [],
            "statistics" => []
        ];

        // --------------------
        // Build hours per day
        
        for($i = 0; $i < count($days); $i++)
        {
            array_push($statistics["days"], $this->countImagesPerHour($days[$i])['total']);
        }

        // ------------------------
        // Average images per hour

        $statistics["statistics"]["average"] = $this->countAverageImagesPerHour($statistics["days"]);

        return $statistics;
    }

    public function countImagesPerHour($day)
    {
        // -------------------------------------
        // Cache hours for x seconds

        $key = $this->user->username . "_" . $day . "_hours";

        $hours = $this->cache->storeAndGet($key, function() use ($day)
        {
            $startTimestamp = intval($this->date->dateToTimestamp($day));
            $endTimestamp = intval($this->date->nextDayToTimestamp($day));
        
            $hours = [ 
                'total' => [0, 0, 0, 0 ,0, 0,
                            0, 0, 0, 0 ,0, 0,
                            0, 0, 0, 0 ,0, 0,
                            0, 0, 0, 0 ,0, 0],
                'instances' => []
            ];
            
            $heap = $this->getImagesFromFilesystem();
            $indexTimestamp = $this->getIndexOfTimestampFromFileFormat();
            $indexInstanceName = $this->getIndexOfInstanceNameFromFileFormat();
            
            // ---------------------------------------------
            // Iterate while timestamp is not in current day
            
            while($heap->valid())
            {
                $timestamp = intval(explode('_', $heap->current())[$indexTimestamp]);
                
                if($timestamp <= $endTimestamp)
                {
                    break;
                }
                
                $heap->next();
            }
            
            while($heap->valid())
            {
                $pieces = explode('_', $heap->current());
                $timestamp = intval($pieces[$indexTimestamp]);
                
                if($timestamp < $startTimestamp)
                {
                    break;
                }

                $hour = intval(($timestamp - $startTimestamp) / 3600);
                $hours['total'][$hour]++;
                
                $instanceName = $pieces[$indexInstanceName];
                if(array_key_exists($instanceName, $hours['instances']))
                {
                    $hours['instances'][$instanceName][$hour]++;
                }
                else
                {
                    $hours['instances'][$instanceName] = [0, 0, 0, 0 ,0, 0,
                                                          0, 0, 0, 0 ,0, 0,
                                                          0, 0, 0, 0 ,0, 0,
                                                          0, 0, 0, 0 ,0, 0];
                }
                
                $heap->next();
            }
            
            return $hours;
        });
        
        return $hours;
    }

    public function countAverageImagesPerHour($hoursPerDay)
    {
        $hours = [0, 0, 0, 0 ,0, 0,
                  0, 0, 0, 0 ,0, 0,
                  0, 0, 0, 0 ,0, 0,
                  0, 0, 0, 0 ,0, 0];
        
        $images = [];
        foreach ($hoursPerDay as $key => $hoursForDay)
        {
            for($i = 0; $i < count($hoursForDay); $i++)
            {
                $hours[$i] += $hoursForDay[$i]['total'];
            }
        }
        
        $numberOfDays = count($hoursPerDay);
        for($i = 0; $i < 24; $i++)
        {
            $hours[$i] = intval($hours[$i] / $numberOfDays);
        }

        return $hours;
    }

    public function getNumberOfImagesPerWeekDayPerInstance($numberOfWeeks)
    {
        $days = $this->getDays($numberOfWeeks * 7 + 1);
        
        $imagesPerWeekDay = [];

        if(count($days) == 0)
        {
            return $imagesPerWeekDay;
        }
        
        // -----------------------------------
        // Get images per weekday per instance

        foreach($days as $day)
        {
            $dayOfWeek = $this->date->getWeekday($day);
            $hours = $this->countImagesPerHour($day);
            
            foreach($hours['instances'] as $instanceName => $instanceHours)
            {
                if(array_key_exists($instanceName, $imagesPerWeekDay))
                {
                    if(!in_array($day, $imagesPerWeekDay[$instanceName]['daysPerWeekday'][$dayOfWeek]))
                    {
                        array_push($imagesPerWeekDay[$instanceName]['daysPerWeekday'][$dayOfWeek], $day);
                    }
                    
                    foreach($instanceHours as $hour)
                    {
                        $imagesPerWeekDay[$instanceName]['eventsOnWeekday'][$dayOfWeek] += $hour;
                    }
                }
                else
                {
                    $imagesPerWeekDay[$instanceName] = [
                        'eventsOnWeekday' => [0, 0, 0, 0, 0, 0, 0],
                        'daysPerWeekday' => [[], [], [], [], [], [], []]
                    ];
                }
            }
        }

        return $imagesPerWeekDay;
    }

    public function getNumberOfImagesPerDayForLastDays($numberOfDays, $averageDays)
    {
        $days = $this->getDays($numberOfDays);

        $statistics = [
            "days" => [],
            "statistics" => []
        ];

        // --------------------
        // Build hours per day

        for($i = 0;$i < count($days); $i++)
        {
            array_push($statistics["days"], $this->countImagesPerDay($days[$i]));
        }

        // -----------------------
        // Average images per day

        $statistics["statistics"] = [
            "average" => $this->countAverageImagesPerDay($statistics["days"]),
        ];

        return $statistics;
    }

    public function countImagesPerDay($day)
    {
        $hours = $this->countImagesPerHour($day);
        
        $total = 0;
        for($i = 0; $i < count($hours['total']); $i++)
        {
            $total += $hours['total'][$i];
        }
        
        return $total;
    }

    public function countAverageImagesPerDay($imagesPerDay)
    {
        $averagePerDay = 0;
        foreach ($imagesPerDay as $key => $imagesForDay)
        {
            $averagePerDay += $imagesForDay;
        }

        $numberOfDays = count($imagesPerDay);
        if($averagePerDay > 0)
        {
            return intval($averagePerDay / $numberOfDays);
        }
        else
        {
            return $averagePerDay;
        }
    }
}