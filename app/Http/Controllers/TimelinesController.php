<?php


namespace App\Http\Controllers;

use App\Http\Requests\TimelineFormRequest;
use App\Models\Mongo\Timeline;

/**
 * Class TimelinesController
 * @package App\Http\Controllers
 */
class TimelinesController extends Controller
{
    /**
     * @return mixed
     */
    public function getIndex()
    {
        return view('timeline', [
            'timelines' => Timeline::get()
        ]);
    }

    /**
     * @return mixed
     */
    public function getCreate()
    {
        return view('timelines.form');
    }

    /**
     * @param TimelineFormRequest $request
     * @return mixed
     */
    public function postCreate(TimelineFormRequest $request)
    {
        if (\Request::get('end_date') != '') {
            $end_date = \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('end_date'));
        } else {
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

    /**
     * @param $timeline_id
     * @param TimelineFormRequest $request
     * @return mixed
     */
    public function postEdit($timeline_id, TimelineFormRequest $request)
    {
        $timeline = Timeline::find($timeline_id);

        if (\Request::get('end_date') != '') {
            $end_date = \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('end_date'));
        } else {
            $end_date = null;
        }


        $timeline->name = \Request::get('name');
        $timeline->color = \Request::get('color');
        $timeline->start_date = \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('start_date'));
        $timeline->end_date = $end_date;

        $timeline->save();

        return redirect(action('\App\Http\Controllers\TimelinesController@getIndex'));
    }

    /**
     * @param $timeline_id
     * @return mixed
     */
    public function getEdit($timeline_id)
    {
        return view('timelines.form', [
            'timeline' => Timeline::find($timeline_id)
        ]);
    }

    /**
     * @param $timeline_id
     * @return mixed
     */
    public function getDelete($timeline_id)
    {
        Timeline::find($timeline_id)->delete();

        return redirect(action('\App\Http\Controllers\TimelinesController@getIndex'));
    }
}