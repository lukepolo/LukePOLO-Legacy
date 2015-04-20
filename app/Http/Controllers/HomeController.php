<?php

namespace App\Http\Controllers;


use App\Models\Mongo\Timeline;
use App\Models\Mongo\Project;
use App\Models\Mongo\Technology;

class HomeController extends Controller
{
    public function index()
    {
        $timelines = Timeline::get();

        return view('home', [
            'projects' => Project::orderBy('start_date', 'desc')->get(),
            'timelines' => $timelines,
            'technologies' => Technology::get()->keyBy('_id')
        ]);
    }
}
