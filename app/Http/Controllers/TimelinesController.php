<?php


namespace App\Http\Controllers;

use App\Http\Requests\TimelineFormRequest;
use \App\Models\Mongo\Timeline;

class TimelinesController extends Controller
{
    public function getIndex()
    {
        return view('timeline', [
            'timelines' => Timeline::get()
        ]);
    }

    public function getCreate()
    {
        return view('timelines.form');
    }

    public function postCreate(TimelineFormRequest $request)
    {
        if(\Request::get('end_date') != '')
        {
            $end_date = \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('end_date'));
        }
        else
        {
            $end_date = null;
        }

        Timeline::create([
            'name' => \Request::get('name'),
            'color' => \Request::get('color'),
            'start_date' => \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('start_date')),
            'end_date' => $end_date
        ]);

        return redirect(action('\App\Http\Controllers\TimelinesController@getIndex'));
    }

    public function postEdit($timeline_id, TimelineFormRequest $request)
    {
        $timeline = Timeline::find($timeline_id);

        if(\Request::get('end_date') != '')
        {
            $end_date = \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('end_date'));
        }
        else
        {
            $end_date = null;
        }


        $timeline->name = \Request::get('name');
        $timeline->color = \Request::get('color');
        $timeline->start_date = \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('start_date'));
        $timeline->end_date = $end_date;

        $timeline->save();

        return redirect(action('\App\Http\Controllers\TimelinesController@getIndex'));
    }

    public function getEdit($timeline_id)
    {
        return view('timelines.form', [
            'timeline' => Timeline::find($timeline_id)
        ]);
    }

    public function getDelete($timeline_id)
    {
        Timeline::find($timeline_id)->delete();

        return redirect(action('\App\Http\Controllers\TimelinesController@getIndex'));
    }
}