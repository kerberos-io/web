<?php namespace App\Http\Repositories\Date;

interface DateInterface
{
    /******************************
     *  Format d-m-Y to timestamp
     */
    public function dateToTimestamp($date);

    /******************************
     *  Format d-m-Y H to timestamp
     */
    public function dateTimeToTimestamp($date, $time);

    /******************************
     *  Get timestamp of next day
     */
    public function nextDayToTimestamp($date);
}
