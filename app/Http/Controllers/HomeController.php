<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Timeline;
use App\Models\Mongo\Projects;
use App\Models\Mongo\Technologies;

class HomeController extends Controller
{
    public function index()
    {
        $timelines = Timeline::get();

        return view('home', [
            'projects' => Projects::orderBy('start_date', 'desc')->get(),
            'timelines' => $timelines,
            'technologies' => Technologies::get()->keyBy('_id')
        ]);
    }
}
