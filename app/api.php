<?php

/**********************************
*
*               API V1
*
**********************************/

Route::group(array('prefix' => 'api/v1'), function()
{
    // -----------------
    // Webhook Controller
    
    Route::resource('webhook', 'Controllers\WebhookController');
    
    // -------------------
    // Health Controller
        
    Route::get('health', 'Controllers\HealthController@index');
    
    // -----------------------------
    // Login method if not authorized
    
    Route::group(['before' => 'guest'], function()
    {
        // -----------------
        // Login Controller
        
        Route::post('login/login', 'Controllers\LoginController@login'); // try to sign-in the user.
    });
    
    // ----------------------
    // Methods for authorized
    
    Route::group(['before' => 'auth'], function()
    {   
        // -----------------
        // User Controller

        Route::get('users/current', 'Controllers\UserController@current');
        Route::post('users/current', 'Controllers\UserController@updateCurrent');

        // -----------------
        // System Controller
        
        Route::get('images/download', 'Controllers\SystemController@downloadImages');
        Route::get('images/clean', 'Controllers\SystemController@cleanImages');
        Route::get('system/download', 'Controllers\SystemController@downloadConfiguration');
        Route::get('system/stream', 'Controllers\SystemController@isStreamRunning');
        Route::get('system/versions', 'Controllers\SystemController@getVersions');
        Route::post('system/upgrade/download', 'Controllers\SystemController@download');
        Route::post('system/upgrade/progress', 'Controllers\SystemController@progress');
        Route::get('system/upgrade/unzip', 'Controllers\SystemController@unzip');
        Route::get('system/upgrade/depack', 'Controllers\SystemController@depack');
        Route::get('system/upgrade/transfer', 'Controllers\SystemController@transfer');
        Route::get('system/upgrade/reboot', 'Controllers\SystemController@reboot');
        Route::get('system/reboot', 'Controllers\SystemController@rebooting');
        Route::get('system/shutdown', 'Controllers\SystemController@shuttingdown');

        Route::get('system/os', 'Controllers\SystemController@getOS');
        Route::get('system/kerberos', 'Controllers\SystemController@getKerberos');
        Route::get('system/kios', 'Controllers\SystemController@getKiOS');
        
        // -----------------
        // Image Controller
        
        Route::get('images/latest_sequence', 'Controllers\ImageController@getLatestSequence');
        Route::get('images/days', 'Controllers\ImageController@getDays');
        Route::get('images/regions', 'Controllers\ImageController@getRegions');
        Route::get('images/perhour/{days?}', 'Controllers\ImageController@getImagesPerHour');
        Route::get('images/perday/{days?}', 'Controllers\ImageController@getImagesPerDay');
        Route::get('images/perweekday/{days?}', 'Controllers\ImageController@getAverageImagesPerWeekDay');
        Route::get('images/{date}/hours', 'Controllers\ImageController@getImagesPerHourForDay');
        Route::get('images/{date}/{take?}/{page?}', 'Controllers\ImageController@getImages');
        Route::get('images/{date}/{take?}/{page?}/{time?}', 'Controllers\ImageController@getImagesFromStartTime');
        
    });
    
    // -------------------------
    // REST API with basic auth 
    
    Route::group(['before' => 'auth.basic'], function()
    {
        // --------------------
        // Settings Controller

        Route::get('name', 'Controllers\SettingsController@getName');
        Route::put('name', 'Controllers\SettingsController@updateName');
    
        Route::get('condition', 'Controllers\SettingsController@getConditions');
        Route::put('condition', 'Controllers\SettingsController@updateConditions');
        Route::get('condition/enabled', 'Controllers\SettingsController@getConditionEnabled');
        Route::put('condition/enabled', 'Controllers\SettingsController@updateConditionEnabled');

	    Route::get('stream', 'Controllers\SettingsController@getStream');
        
        Route::get('io', 'Controllers\SettingsController@getIos');
        Route::put('io', 'Controllers\SettingsController@updateIos');
        Route::get('io/webhook', 'Controllers\SettingsController@getIoWebhook');
        Route::put('io/webhook', 'Controllers\SettingsController@updateIoWebhook');

        Route::get('configure', array('uses' => 'Controllers\SettingsController@getConfiguration'));
        Route::put('configure', array('uses' => 'Controllers\SettingsController@changeProperties'));

        // --------------------
        // System Controller

        Route::get('system/health', 'Controllers\SystemController@isStreamRunning');
        Route::post('system/reboot', 'Controllers\SystemController@rebooting');
        Route::post('system/shutdown', 'Controllers\SystemController@shuttingdown');

        App::missing(function($exception)
        {
            return Response::json([
                'error' => 'API method does not exists'
            ], 404);
        });
    });

    
    // -----------------
    // Translate Controller

    Route::get('translate/{page}', 'Controllers\TranslateController@index');

    // --------------------
    // Installation wizard

    if(!Config::get('kerberos')['installed'])
    {
        Route::post('user/language', 'Controllers\UserController@changeLanguage');
        Route::post('user/install', 'Controllers\UserController@install');
    }
});

/**********************************
*
*               API V2
*
**********************************/

Route::group(array('prefix' => 'api/v2'), function(){});
