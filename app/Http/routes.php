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

Route::group(['middleware' => 'web'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('login', 'Auth\AuthController@getLogin');
    Route::get('auth/service/{provider}', 'Auth\AuthController@getService');
    Route::get('register', 'Auth\AuthController@getLogin');
    Route::get('logout', 'Auth\AuthController@getLogout');

    Route::get('blog', 'BlogController@getPublicIndex');
    Route::get('blog/view/{blog}', [
        'as' => 'blog/view',
        function ($blog) {
            $blog = \App\Models\Mongo\Blog::where('link_name', $blog)->first();
            if (empty($blog) === false) {

                return App::make('\App\Http\Controllers\BlogController')->getView($blog->id);
            } else {
                App::abort(404);
            }
        }
    ]);

    Route::get('resume', 'ResumeController@getIndex');
});

Route::group(['middleware' => 'web'], function () {

    Route::get('admin', 'AdminController@getIndex');

    Route::group(['prefix' => 'admin'], function() {
        Route::resource('comments', 'CommentsController');
        Route::resource('comment-vote', 'CommentVotesController');

        Route::get('comment/{commentID}', 'AdminController@getComment');
        Route::get('visits', 'AdminController@getVisits');
        Route::get('popularPages', 'AdminController@getPopularPages');
        Route::post('markAsRead', 'AdminController@postMarkRead');

        Route::get('settings', 'SettingsController@getIndex');

        /*
        |--------------------------------------------------------------------------
        | Project Links
        |--------------------------------------------------------------------------
        */
        Route::get('projects', 'ProjectsController@getIndex');
        Route::get('projects/create', 'ProjectsController@getCreate');
        Route::post('projects/create', 'ProjectsController@postCreate');
        Route::get('projects/edit/{projectID}', 'ProjectsController@getEdit');
        Route::post('projects/edit{projectID}', 'ProjectsController@postEdit');
        Route::get('projects/delete/{projectID}', 'ProjectsController@getDelete');

        /*
        |--------------------------------------------------------------------------
        | Blog Routes
        |--------------------------------------------------------------------------
        */
        Route::get('blogs', 'BlogController@getAdminIdex');
        Route::get('blog/create', 'BlogController@getCreate');
        Route::post('blog/create', 'BlogController@getCreate');
        Route::get('blog/edit/{blogID}', 'BlogController@getEdit');
        Route::post('blog/edit/{blogID}', 'BlogController@postEdit');
        Route::get('blog/delete/{blogID}', 'BlogController@getDelete');

        /*
        |--------------------------------------------------------------------------
        | Timeliness Routes
        |--------------------------------------------------------------------------
        */
        Route::get('timeliness', 'TimelinessController@getIndex');
        Route::get('timeline/create', 'TimelinessController@getCreate');
        Route::post('timeline/create', 'TimelinessController@postCreate');
        Route::get('timeline/edit/{timelineID}', 'TimelinessController@getEdit');
        Route::post('timeliness/edit/{timelineID}', 'TimelinessController@postEdit');
        Route::get('timeliness/delete/{timelineID}', 'TimelinessController@getDelete');

        /*
        |--------------------------------------------------------------------------
        | Technologies Routes
        |--------------------------------------------------------------------------
        */
        Route::get('technologies', 'TechnologiesController@getIndex');
        Route::get('technologies/create', 'TechnologiesController@getCreate');
        Route::post('technologies/create', 'TechnologiesController@postCreate');
        Route::get('technologies/edit/{timelineID}', 'TechnologiesController@getEdit');
        Route::post('technologies/edit/{timelineID}', 'TechnologiesController@postEdit');
        Route::get('technologies/delete/{timelineID}', 'TechnologiesController@getDelete');

        /*
        |--------------------------------------------------------------------------
        | Projects
        |--------------------------------------------------------------------------
        */
        Route::get('tags', 'TagsController@getIndex');
        Route::get('tags/create', 'TagsController@getCreate');
        Route::post('tags/create', 'TagsController@postCreate');
        Route::get('tags/edit/{timelineID}', 'TagsController@getEdit');
        Route::post('tags/edit/{timelineID}', 'TagsController@postEdit');
        Route::get('tags/delete/{timelineID}', 'TagsController@getDelete');
    });
});