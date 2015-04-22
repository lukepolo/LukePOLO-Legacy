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
    'resume' => 'ResumeController',
]);

Route::get('blog/view/{blog}', ['as' => 'blog/view', function($blog)
{
    $blog = \App\Models\Mongo\Blog::where('link_name', '=', $blog)->first();
    if(empty($blog) === false)
    {

        return App::make('\App\Http\Controllers\BlogController')->getView($blog->id);
    }
    else
    {
        App::abort(404);
    }
}]);

// Only Loggged IN - Redirects to Login Page if not logged in
Route::group(['middleware' => 'admin'], function()
{
    // Controllers Go Here
    Route::controllers([
        'admin' => 'AdminController',
        'settings' => 'SettingsController',
        'timelines' => 'TimelinesController',
        'technologies' => 'TechnologiesController',
        'projects' => 'ProjectsController',
        'blog' => 'BlogController'
    ]);
});

// Only Loggged IN - Redirects to Login Page if not logged in
Route::group(['middleware' => 'auth'], function()
{
    Route::resource('comments', 'CommentsController');
    Route::resource('comment-vote', 'CommentVotesController');
});


Route::get('blog', 'BlogController@getIndex');

// Auth Traits
Route::get('login', 'Auth\AuthController@getLogin');
Route::get('register', 'Auth\AuthController@getLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

