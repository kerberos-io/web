<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(env('KERBEROSIO_SECURE_SSL') === true || env('SECURE_SSL', false) === true)
        {
            $this->app['request']->server->set('HTTPS', true);
        }

        /**********************************
        *
        *   Bind repositories to controllers
        *   (Dependency Injection)
        *
        **********************************/

        $this->app->bind('App\Http\Repositories\ImageHandler\ImageHandlerInterface',
                         'App\Http\Repositories\ImageHandler\ImageFileSystemHandler');

        $this->app->bind('App\Http\Repositories\Filesystem\FilesystemInterface',
                         'App\Http\Repositories\Filesystem\DiskFilesystem');

        $this->app->bind('App\Http\Repositories\ConfigReader\ConfigReaderInterface',
                         'App\Http\Repositories\ConfigReader\ConfigXMLReader');

        $this->app->bind('App\Http\Repositories\Date\DateInterface',
                         'App\Http\Repositories\Date\Carbon');

        $this->app->bind('App\Http\Repositories\Support\SupportInterface',
                         'App\Http\Repositories\Support\ZendeskSupport');
    }
}
