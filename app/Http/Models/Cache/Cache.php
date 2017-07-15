<?php namespace App\Http\Models\Cache;

use Session;

class Cache implements CacheInterface
{
	private $cachingTime;

    public function __construct($cachingTime)
    {
        $this->cachingTime = $cachingTime;
    }

    public function storeAndGet($key, $function)
    {
        $time = time();
        $valueFromCache = Session::get($key, [$key => [], 'time' => 0]);

        if($time - $valueFromCache['time'] >= $this->cachingTime)
        {
            Session::forget($key);

            $valueFromFunction = $function();
            $valueFromCache = [$key => $valueFromFunction, 'time' => $time];

            Session::put($key, $valueFromCache);
        }

        return $valueFromCache[$key];
    }

    public function forget($key)
    {
        Session::forget($key);
    }
}
