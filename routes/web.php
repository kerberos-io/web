<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['has.configuration', 'has.captureDirectory'])->group(function()
{
    Route::middleware('not.authenticated')->group(function()
    {
        // -----------------
        // Login Controller

        Route::get('login', 'LoginController@index');

        // ----------------------------------------
        // Welcome controller, for first time setup.

        if(!Config::get('kerberos')['installed'])
        {
            Route::get('welcome', 'WelcomeController@index');
        }
    });

    Route::middleware('authenticated')->group(function()
    {
        // ------------------------
        // Login Controller

        Route::get('logout', 'LoginController@logout');

        // ------------------------
        // Dashboard Controller

        Route::get('/', 'DashboardController@index');

        // ------------------------
        // Settings Controller

        Route::get('settings', 'SettingsController@index');
        Route::get('cloud', 'SettingsController@cloud');
        Route::post('settings/update', ['uses' => 'SettingsController@update']);
        Route::post('settings/update/web', ['uses' => 'SettingsController@updateWeb']);

        // ------------------------
        // System Controller

        Route::get('system', 'SystemController@index');

        // ------------------------
        // Image Controller

        Route::get('images/{date?}', 'ImageController@index');
    });
});
