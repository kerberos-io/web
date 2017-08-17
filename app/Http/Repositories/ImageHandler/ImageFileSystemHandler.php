<?php namespace App\Http\Repositories\ImageHandler;

use Log;
use URL, Session, Config, Auth;
use Carbon\Carbon as Carbon;

use App\Http\Repositories\Filesystem\FilesystemInterface as FilesystemInterface;
use App\Http\Repositories\Date\DateInterface as DateInterface;
use App\Http\Repositories\ConfigReader\ConfigReaderInterface as ConfigReaderInterface;
use App\Http\Models\Filesystem\Image as Image;
use App\Http\Models\Cache\Cache as Cache;

class ImageFileSystemHandler implements ImageHandlerInterface
{
    public function __construct(ConfigReaderInterface $reader,
                                FilesystemInterface $filesystem, DateInterface $date)
    {
        $this->cache = new Cache(Config::get('session.lifetime'));
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

        // -----------------------------------------------------------------------------
        // Work-a-round for shorter timestamps, no numerical sorting is applied in heap
        // sort because it would decreases performance enourmously (split of key)
        // Therefore we make sure the string is long enough.
        //
        // -- Why is this needed?
        //
        // Usecase; it's possible that kerberos.io works without a working internet
        // connection, and therefore wrong timestamps are assigned to the images typically
        // from the beginning of the unix epoch - 01-01-1970

        $index = $this->getIndexOfTimestampFromFileFormat();

        while($heap->valid() && !$heap->isEmpty())
        {
            $current = $heap->current();
            $timestamp = explode('_', $current)[$index];
            $numberOfZeros = strlen("1000000000") - strlen($timestamp);
            if($numberOfZeros == 0)
            {
                break;
            }

            $heap->extract();
            $heap->insert(str_repeat("0", $numberOfZeros) . $current);
        }

        return $heap;
    }

    public function getLatestImage()
    {
        $latestSequence = $this->getLatestSequence();

        // Filter out videos..
        $latestSequence = array_where($latestSequence, function ($value, $key)
        {
            return $value['type'] === 'image';
        });

        if(count($latestSequence)>0)
        {
            $i = count($latestSequence) -1;
            return $latestSequence[$i]["src"];
        }

        return "";
    }

    public function getLatestSequence()
    {
        $key = Auth::user()->username . "_latestSequence";

        $days = $this->getDays(1);

        if(count($days) > 0)
        {
            $day = $days[0];
            $images = $this->getImagesSequenceFromDay($day, 1, 120);
            return array_values($images);
        }

        return [];
    }

    public function getSecondLatestSequence()
    {
        $key = Auth::user()->username . "_secondLatestSequence";

        $days = $this->getDays(1);

        if(count($days) > 0)
        {
            $day = $days[0];
            $images = $this->getImagesSequenceFromDay($day, 2, 120);
            return array_values($images);
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

        $key = Auth::user()->username . "_days";

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

                if(!is_numeric($timestamp))
                {
                    $heap->next();
                    continue;
                }

                $rest = floor(($timestamp - $startTimestamp) / 86400);

                if($restCheck != $rest)
                {
                    $restCheck = $rest;
                    array_push($days, $carbon->addDays($rest)->format('d-m-Y'));
                    $carbon->subDays($rest);
                }

                // --------------------------------------------
                // at this point we have all the images, but we
                // need to sort them.

                $heap->next();
            }

            // Transformdates
            $timestamps = [];
            foreach($days as $day)
            {
                array_push($timestamps, $this->date->dateToTimestamp($day));
            }

            asort($timestamps);

            $days = [];
            foreach($timestamps as $timestamp)
            {
                array_push($days, $this->date->timestampToDate($timestamp));
            }

            return array_reverse($days);
        });

        // --------------------
        // Clear cache if empty

        if(!count($days))
        {
            $this->cache->forget($key);
        }

        if($numberOfDays > 0)
        {
            return array_slice($days, 0, $numberOfDays);
        }
        else
        {
            return $days;
        }
    }

    public function getRegions($numberOfRegions)
    {
        // -------------------------------------
        // Cache images directory for x seconds

        $key = Auth::user()->username . "_regions";

        $regions = $this->cache->storeAndGet($key, function() use ($numberOfRegions)
        {
            $heap = $this->getImagesFromFilesystem();

            $regions = [];

            $i = 0;
            while($i++ < $numberOfRegions && $heap->valid())
            {
                $image = new Image;
                $image->setTimezone($this->date->timezone);
                $image->parse($heap->current());

                array_push($regions, [
                    "regionCoordinates" => $image->getRegion(),
                    "numberOfChanges" => $image->getChanges()
                ]);
                $heap->next();
            }

            return $regions;
        });

        // --------------------
        // Clear cache if empty

        if(!count($regions))
        {
            $this->cache->forget($key);
        }

        return $regions;
    }

    public function getImages()
    {
        $heap = $this->getImagesFromFilesystem();

        $images = [];
        while($heap->valid())
        {
            array_push($images, $heap->current());
            $heap->next();
        }

        return $images;
    }

    public function getNumberOfImages()
    {
        $heap = $this->getImagesFromFilesystem();
        return $heap->count();
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

        $data = [];

        // ------------------------------------------
        // Filter images that belong to selected page

        foreach($imagesTemp as $key => $image)
        {
            if($key >= $lower && $key < $upper)
            {
                $path = ltrim($image['path'], "0");

                $image = new Image;
                $image->setTimezone($this->date->timezone);
                $image->parse($path);

                $path = $this->filesystem->getPathToFile($image);
                $systemPath = $this->filesystem->getSystemPathToFile($image);

                try
                {
                    $object = [
                        'time' => $image->getTime(),
                        'src' => $path,
                        'local_src' => $systemPath,
                        'metadata' => $this->filesystem->getMetadata($image)
                    ];

                    if(getimagesize($systemPath)['mime'] == 'image/jpeg')
                    {
                        $object['type'] = 'image';

                    }
                    else
                    {
                         $object['type'] = 'video';
                    }

                    array_push($data, $object);
                }
                catch(\Exception $ex){}
            }
        }

        return $data;
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

        // We will use getID3 to check if media this.
        $getID3 = new \getID3;

        $data = [];
        foreach($imagesTemp as $image)
        {
            $path = ltrim($image['path'], "0");

            $image = new Image;
            $image->setTimezone($this->date->timezone);
            $image->parse($path);

            $path = $this->filesystem->getPathToFile($image);
            $systemPath = $this->filesystem->getSystemPathToFile($image);
            $mediaInfo = $getID3->analyze($systemPath);

            try
            {
                $object = [
                    'time' => $image->getTime(),
                    'src' => $path,
                    'local_src' => $systemPath,
                    'metadata' => $this->filesystem->getMetadata($image)
                ];

                if(array_key_exists('error', $mediaInfo) || $mediaInfo['fileformat'] !== 'jpg')
                {
                    $object['type'] = 'video';
                }
                else
                {
                     $object['type'] = 'image';
                }

                array_push($data, $object);
            }
            catch(\Exception $ex){}
        }

        return $data;
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

            $images = array_where($images, function($value, $key) use ($start, $end)
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
            "statistics" => [],
            "legend" => [
                "today" => \Lang::get('general.today'),
                "yesterday" => \Lang::get('general.yesterday'),
                "dayBeforeYesterday" => \Lang::get('general.dayBeforeYesterday'),
                "average" => \Lang::get('dashboard.average')
            ]
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

        $key = Auth::user()->username . "_" . $day . "_hours";

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

                if(count($pieces) <= $indexInstanceName)
                {
                    $heap->next();
                    continue;
                }

                $timestamp = intval($pieces[$indexTimestamp]);

                if($timestamp < $startTimestamp)
                {
                    break;
                }

                $hour = intval(($timestamp - $startTimestamp) / 3600) % 24;
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

        // --------------------
        // Clear cache if empty

        if(!count($hours['instances']))
        {
            $this->cache->forget($key);
        }

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
                $hours[$i] += $hoursForDay[$i];
            }
        }

        $numberOfDays = count($hoursPerDay);
        for($i = 0; $i < 24; $i++)
        {
            $hours[$i] = $numberOfDays==0 ? 0 : intval($hours[$i] / $numberOfDays);
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

        $legend = [
            "monday" => \Lang::get('general.monday'),
            "tuesday" => \Lang::get('general.tuesday'),
            "wednesday" => \Lang::get('general.wednesday'),
            "thursday" => \Lang::get('general.thursday'),
            "friday" => \Lang::get('general.friday'),
            "saturday" => \Lang::get('general.saturday'),
            "sunday" => \Lang::get('general.sunday'),
        ];

        return [
            'instances' => $imagesPerWeekDay,
            'legend' => $legend
        ];
    }

    public function getNumberOfImagesPerDayForLastDays($numberOfDays, $averageDays)
    {
        $days = $this->getDays($numberOfDays);

        $statistics = [
            "days" => [],
            "statistics" => [],
            "legend" => [
                "today" => \Lang::get('general.today'),
                "yesterday" => \Lang::get('general.yesterday'),
                "dayBeforeYesterday" => \Lang::get('general.dayBeforeYesterday'),
                "average" => \Lang::get('dashboard.average')
            ]
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
