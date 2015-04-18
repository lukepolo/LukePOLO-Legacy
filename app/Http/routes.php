<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
    'blog' => 'BlogController',
    'resume' => 'ResumeController',
    'technologies' => 'TechnologiesController'

]);
// Only Loggged IN - Redirects to Login Page if not logged in
Route::group(['middleware' => 'auth'], function()
{
    // Controllers Go Here
    Route::controllers([
        'admin' => 'AdminController',
        'settings' => 'SettingsController',
        'timelines' => 'TimelinesController',
        'projects' => 'ProjectsController',
    ]);
});

Route::get('login', 'Auth\AuthController@getLogin');
Route::get('register', 'Auth\AuthController@getLogin');
Route::get('logout', 'Auth\AuthController@getLogout');