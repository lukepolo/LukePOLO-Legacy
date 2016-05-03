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

Route::group(['middleware' => 'admin'], function () {
    Route::resource('comments', 'CommentsController');
    Route::resource('comment-vote', 'CommentVotesController');
});

Route::get('/', 'HomeController@index');
Route::get('login', 'Auth\AuthController@getLogin');
Route::get('auth/service/{provider}', 'Auth\AuthController@getService');
Route::get('register', 'Auth\AuthController@getLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

Route::get('blog', 'BlogController@getIndex');
Route::get('blog/view/{blog}', [
    'as' => 'blog/view',
    function ($blog) {
        $blog = \App\Models\Mongo\Blog::where('link_name', '=', $blog)->first();
        if (empty($blog) === false) {

            return App::make('\App\Http\Controllers\BlogController')->getView($blog->id);
        } else {
            App::abort(404);
        }
    }
]);

Route::get('/resume', 'ResumeController@getIndex');