<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['before' => 'guest'], function()
{
	// ------------------------
    // Login Controller

    Route::get('login', 'Controllers\LoginController@index');
});

Route::group(['before' => 'auth'], function()
{
	// ------------------------
    // Login Controller

    Route::get('logout', 'Controllers\LoginController@logout');

    // ------------------------
    // Dashboard Controller

    Route::get('/', 'Controllers\DashboardController@index');
    
    // ------------------------
    // Settings Controller

    Route::get('settings', 'Controllers\SettingsController@index');
    Route::get('cloud', 'Controllers\SettingsController@cloud');
    Route::post('settings/update', array('uses' => 'Controllers\SettingsController@update'));
    
    // ------------------------
    // Image Controller

    Route::get('images/{date?}', 'Controllers\ImageController@index');
});