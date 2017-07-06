<?php namespace App\Http\Models\Cache;

use Cache as LCache;

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
        $valueFromCache = LCache::get($key, [$key => [], 'time' => 0]);

        if($time - $valueFromCache['time'] >= $this->cachingTime)
        {
            LCache::forget($key);

            $valueFromFunction = $function();
            $valueFromCache = [$key => $valueFromFunction, 'time' => $time];

            LCache::put($key, $valueFromCache, 999999);
        }

        return $valueFromCache[$key];
    }

    public function forget($key)
    {
        LCache::forget($key);
    }
}
