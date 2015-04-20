<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

    function __construct()
    {
        // Sets the Title, based on the controller
        $name = preg_replace('/Controller@.*/', '', str_replace(\Route::getCurrentRoute()->getAction()["namespace"].'\\', '', \Route::currentRouteAction()));
        \View::share('title', '{ LukePOLO | '.$name);
    }
}
