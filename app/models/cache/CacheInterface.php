<?php namespace Models\Cache;

interface CacheInterface
{
    /******************************
     *  Store or get key from cache
     */
	public function storeAndGet($key, $function); 
}