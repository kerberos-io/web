<?php namespace Models\Data;

use SplHeap;

class Heap extends SplHeap
{
    public function compare($a, $b)
    {
        if ($a === $b) return 0;
        return $a > $b ? 1 : -1;
    }
}
