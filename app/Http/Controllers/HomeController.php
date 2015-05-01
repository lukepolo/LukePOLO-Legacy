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
            'projects' => Project::with('timeline')->orderBy('start_date', 'desc')->get(),
            'technologies' => Technology::get()->keyBy('_id'),
            'timelines' => Timeline::get()
        ]);
    }
}
