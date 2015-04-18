<?php

namespace App\Http\Controllers;

use \App\Models\Mongo\Timeline;

class HomeController extends Controller
{
    public function index()
    {
        $timelines = Timeline::get();

        return view('home', [
            'timelines' => $timelines
        ]);
    }
}
