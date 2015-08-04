<?php

namespace repositories\date;

use Carbon\Carbon as Carbon_;

class Carbon extends Carbon_ implements DateInterface
{
    public function dateToTimestamp($date)
    {
        $dateTime = Carbon_::createFromFormat('d-m-Y h:i:s', $date.' 00:00:00', $this->timezone);

        return $dateTime->timestamp;
    }

    public function dateTimeToTimestamp($date, $time)
    {
        $dateTime = Carbon_::createFromFormat('d-m-Y H:i:s', $date.' '.$time.':00:00', $this->timezone);

        return $dateTime->timestamp;
    }

    public function nextDayToTimestamp($date)
    {
        $dateTime = Carbon_::createFromFormat('d-m-Y h:i:s', $date.' 00:00:00', $this->timezone);
        $tomorrow = $dateTime->addDay();

        return $tomorrow->timestamp;
    }
}
