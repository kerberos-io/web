<?php

/**********************************
*
*               API V1
*
**********************************/

Route::group(array('prefix' => 'api/v1'), function()
{
    Route::group(['before' => 'guest'], function()
    {
        Route::post('login/login', 'Controllers\LoginController@login'); // try to sign-in the user.
    });

    Route::group(['before' => 'auth'], function()
    {
        Route::get('images/latest_sequence', 'Controllers\ImageController@getLatestSequence');
        Route::get('images/days', 'Controllers\ImageController@getDays');
        Route::get('images/perhour/{days?}', 'Controllers\ImageController@getImagesPerHour');
        Route::get('images/perday/{days?}', 'Controllers\ImageController@getImagesPerDay');
        Route::get('images/perweekday/{days?}', 'Controllers\ImageController@getAverageImagesPerWeekDay');
        Route::get('images/{date}/hours', 'Controllers\ImageController@getImagesPerHourForDay');
        Route::get('images/{date}/{take?}/{page?}', 'Controllers\ImageController@getImages');
        Route::get('images/{date}/{take?}/{page?}/{time?}', 'Controllers\ImageController@getImagesFromStartTime');
    });
});

/**********************************
*
*               API V2
*
**********************************/

Route::group(array('prefix' => 'api/v2'), function(){});