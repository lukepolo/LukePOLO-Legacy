<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * Makes a title for all pages
     * Controller constructor.
     */
    function __construct()
    {
        \View::share('title',
            '{ LukePOLO | ' . preg_replace('/Controller@.*/', '',
                str_replace(
                    \Route::getCurrentRoute()->getAction()["namespace"] . '\\',
                    '',
                    \Route::currentRouteAction()
                )
            )
        );
    }
}
