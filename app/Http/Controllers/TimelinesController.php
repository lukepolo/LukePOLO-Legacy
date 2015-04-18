<?php


namespace App\Http\Controllers;

use \App\Models\Mongo\Timeline;

class TimelinesController extends Controller
{
    public function getIndex()
    {
        $timelines = Timeline::get();

        return view('admin.timeline', [
            'timelines' => $timelines
        ]);
    }

    public function postCreate()
    {
        $timeline = Timeline::create([
            'type' => \Request::get('type'),
            'name' => \Request::get('name'),
            'start_date' => \Request::get('start_date'),
            'end_date' => \Request::get('end_date'),
            'description' => \Request::get('description')
        ]);

        $timeline->save();
    }
}