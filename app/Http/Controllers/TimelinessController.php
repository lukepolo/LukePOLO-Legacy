<?php


namespace App\Http\Controllers;

use App\Http\Requests\TimelineFormRequest;
use App\Models\Mongo\Timeline;

/**
 * Class TimelinessController
 * @package App\Http\Controllers
 */
class TimelinessController extends Controller
{
    /**
     * The main timeline view
     * @return mixed
     */
    public function getIndex()
    {
        return view('timeliness.index', [
            'timeliness' => Timeline::get()
        ]);
    }

    /**
     * The create form
     * @return mixed
     */
    public function getCreate()
    {
        return view('timeliness.form');
    }

    /**
     * Creates a new timeline
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

        // TODO - setters for dates

        Timeline::create([
            'name' => \Request::get('name'),
            'color' => \Request::get('color'),
            'start_date' => \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('start_date')),
            'end_date' => $end_date
        ]);

        return redirect(action('\App\Http\Controllers\TimelinessController@getIndex'));
    }

    /**
     * The update form
     * @param $timelineID
     * @return mixed
     */
    public function getEdit($timelineID)
    {
        return view('timeliness.form', [
            'timeline' => Timeline::find($timelineID)
        ]);
    }

    /**
     * Updates a timeline
     * @param $timelineID
     * @param TimelineFormRequest $request
     * @return mixed
     */
    public function postEdit($timelineID, TimelineFormRequest $request)
    {
        $timeline = Timeline::find($timelineID);

        if (\Request::get('end_date') != '') {
            $end_date = \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('end_date'));
        } else {
            $end_date = null;
        }

        // TODO - create a setter
        $timeline->name = \Request::get('name');
        $timeline->color = \Request::get('color');
        $timeline->start_date = \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('start_date'));
        $timeline->end_date = $end_date;

        $timeline->save();

        return redirect(action('\App\Http\Controllers\TimelinessController@getIndex'));
    }
    
    /**
     * Deletes a timeline
     * @param $timelineID
     * @return mixed
     */
    public function getDelete($timelineID)
    {
        Timeline::find($timelineID)->delete();

        return redirect(action('\App\Http\Controllers\TimelinessController@getIndex'));
    }
}