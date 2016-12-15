<?php namespace Models\Data;

use SplHeap;

class Heap extends SplHeap
{
    public function compare($a, $b)
    {
        if ($a === $b) return 0;

        $partsA = explode('_', $a);
        $partsB = explode('_', $b);

        $timeA = intval($partsA[0]);
        $timeB = intval($partsB[0]);

        if($timeA == $timeB)
        {
        	$microA = $partsA[1];
        	$microB = $partsB[1];
        	
        	return $microA > $microB ? 1 : -1;
        }
        else
        {
        	return $timeA > $timeB ? 1 : -1;
        }
    }
}
