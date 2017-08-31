<?php namespace App\Http\Repositories\System;

use Config;

class LinuxSystem extends OSSystem
{
    public function getCPUs()
    {
        $cpus = $this->parser->getCPU();

        foreach($cpus as &$cpu)
        {
            if(!array_key_exists('MHz', $cpu))
            {
                $cpu['MHz'] = '';
            }

            if(!array_key_exists('Vendor', $cpu))
            {
                $cpu['Vendor'] = '';
            }
        }

        return $cpus;
    }
}
