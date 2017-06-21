<?php namespace App;

/*
|--------------------------------------------------------------------------
| Check if running on KiOS
|--------------------------------------------------------------------------
|
| If running on KiOS, data folders are on a different location.
| Therefore we should have a different storage and config directory.
|
*/

class Application extends \Illuminate\Foundation\Application
{
    protected $kios = '/data/etc/kios.conf';

    /**
     * Get the path to the storage directory.
     *
     * @return string
     */

    public function storagePath()
    {
        if(file_exists($this->kios))
        {
            return '/data/web/storage';
        }

        return $this->storagePath ?: $this->basePath.DIRECTORY_SEPARATOR.'storage';
    }

    /**
     * Get the path to the application configuration files.
     *
     * @param string $path Optionally, a path to append to the config path
     * @return string
     */
    public function configPath($path = '')
    {
        if(file_exists($this->kios))
        {
            return '/data/web/config';
        }

        return $this->basePath.DIRECTORY_SEPARATOR.'config'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the bootstrap directory.
     *
     * @param string $path Optionally, a path to append to the bootstrap path
     * @return string
     */
    public function bootstrapPath($path = '')
    {
        if(file_exists($this->kios))
        {
            return '/data/web/bootstrap';
        }

        return $this->basePath.DIRECTORY_SEPARATOR.'bootstrap'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}
