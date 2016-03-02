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
        
        Route::get('io', 'Controllers\SettingsController@getIos');
        Route::put('io', 'Controllers\SettingsController@updateIos');
        Route::get('io/webhook', 'Controllers\SettingsController@getIoWebhook');
        Route::put('io/webhook', 'Controllers\SettingsController@updateIoWebhook');
    });
});

/**********************************
*
*               API V2
*
**********************************/

Route::group(array('prefix' => 'api/v2'), function(){});