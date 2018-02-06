<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/**********************************
*
*               API V1
*
**********************************/

Route::prefix('v1')->group(function()
{
    // -----------------
    // Webhook Controller

    Route::resource('webhook', 'WebhookController');

    // -----------------
    // Login Controller

    Route::post('login/login', 'LoginController@login'); // try to sign-in the user.

    // ----------------------
    // Methods for authorized

    Route::middleware('authenticated')->group(function()
    {
        // -----------------
        // User Controller

        Route::get('users/current', 'UserController@current');
        Route::post('users/current', 'UserController@updateCurrent');

        // -----------------
        // System Controller

        Route::get('images/download', 'SystemController@downloadImages');
        Route::get('images/clean', 'SystemController@cleanImages');
        Route::get('system/download', 'SystemController@downloadConfiguration');
        Route::get('system/stream', 'SystemController@isStreamRunning');
        Route::get('system/versions', 'SystemController@getVersions');
        Route::post('system/upgrade/download', 'SystemController@download');
        Route::post('system/upgrade/progress', 'SystemController@progress');
        Route::get('system/upgrade/unzip', 'SystemController@unzip');
        Route::get('system/upgrade/depack', 'SystemController@depack');
        Route::get('system/upgrade/transfer', 'SystemController@transfer');
        Route::get('system/upgrade/reboot', 'SystemController@reboot');
        Route::get('system/reboot', 'SystemController@rebooting');
        Route::get('system/shutdown', 'SystemController@shuttingdown');

        Route::get('system/os', 'SystemController@getOS');
        Route::get('system/kerberos', 'SystemController@getKerberos');
        Route::get('system/kios', 'SystemController@getKiOS');

        Route::post('cloud/check', 'SystemController@checkCloud');

        // -----------------
        // Image Controller

        Route::get('images/latest_sequence', 'ImageController@getLatestSequence');
        Route::get('images/days', 'ImageController@getDays');
        Route::get('images/regions', 'ImageController@getRegions');
        Route::get('images/perhour/{days?}', 'ImageController@getImagesPerHour');
        Route::get('images/perday/{days?}', 'ImageController@getImagesPerDay');
        Route::get('images/perweekday/{days?}', 'ImageController@getAverageImagesPerWeekDay');
        Route::get('images/{date}/hours', 'ImageController@getImagesPerHourForDay');
        Route::get('images/{date}/{take?}/{page?}', 'ImageController@getImages');
        Route::get('images/{date}/{take?}/{page?}/{time?}', 'ImageController@getImagesFromStartTime');

    });

    // -------------------------
    // REST API with basic auth

    Route::middleware('basic.authenticated')->group(function()
    {
        // --------------------
        // Settings Controller

        Route::get('name', 'SettingsController@getName');
        Route::put('name', 'SettingsController@updateName');

        Route::get('condition', 'SettingsController@getConditions');
        Route::put('condition', 'SettingsController@updateConditions');
        Route::get('condition/enabled', 'SettingsController@getConditionEnabled');
        Route::put('condition/enabled', 'SettingsController@updateConditionEnabled');

        Route::get('stream', 'SettingsController@getStream');

        Route::get('images/latest_sequence', 'ImageController@getLatestSequence');

        Route::get('io', 'SettingsController@getIos');
        Route::put('io', 'SettingsController@updateIos');
        Route::get('io/webhook', 'SettingsController@getIoWebhook');
        Route::put('io/webhook', 'SettingsController@updateIoWebhook');

        Route::put('force-network', 'SettingsController@updateForceNetwork');
        Route::put('auto-removal', 'SettingsController@updateAutoRemoval');

        Route::get('configure', array('uses' => 'SettingsController@getConfiguration'));
        Route::put('configure', array('uses' => 'SettingsController@changeProperties'));

        // --------------------
        // System Controller

        Route::get('system/health', 'SystemController@isStreamRunning');
        Route::post('system/reboot', 'SystemController@rebooting');
        Route::post('system/shutdown', 'SystemController@shuttingdown');

        Route::get('*', function()
        {
            return Response::json([
                'error' => 'API method does not exists'
            ], 404);
        });
    });


    // -----------------
    // Translate Controller

    Route::get('translate/{page}', 'TranslateController@index');

    // --------------------
    // Installation wizard

    Route::get('user/installation', 'UserController@installationCompleted');

    if(!Config::get('kerberos')['installed'])
    {
        Route::post('user/language', 'UserController@changeLanguage');
        Route::post('user/install', 'UserController@install');
    }
});

/**********************************
*
*               API V2
*
**********************************/

Route::prefix('v2')->group(function(){});
