<?php namespace Models\Data;

use SplHeap;

class Heap extends SplHeap
{
    public function compare($a, $b)
    {
        if ($a === $b) return 0;

        $a = intval(explode('_', $a)[0]);
        $b = intval(explode('_', $b)[0]);

        return $a > $b ? 1 : -1;
    }
}
