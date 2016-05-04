<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectFormRequest;
use App\Models\Mongo\Project;
use App\Models\Mongo\Technology;
use App\Models\Mongo\Timeline;

/**
 * Class ProjectsController
 * @package App\Http\Controllers
 */
class ProjectsController extends Controller
{
    /**
     * Main projects page
     * @return mixed
     */
    public function getIndex()
    {
        return view('projects.index', [
            'projects' => Project::with('timeline')->orderBy('start_date', 'dsc')->get()
        ]);
    }

    /**
     * Create form
     * @return mixed
     */
    public function getCreate()
    {
        return view('projects.form', [
            'technologies' => Technology::get(),
            'timelines' => Timeline::get()
        ]);
    }

    /**
     * Creating a project
     * @param ProjectFormRequest $request
     * @return mixed
     */
    public function postCreate(ProjectFormRequest $request)
    {
        if (\Request::has('end_date')) {
            $end_date = \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('end_date'));
        } else {
            $end_date = null;
        }

        // TODO - setting for dates and time

        Project::create([
            'name' => \Request::get('name'),
            'url' => \Request::get('URL'),
            'start_date' => \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('start_date')),
            'end_date' => $end_date,
            'technologies' => \Request::get('technologies'),
            'timeline_id' => \Request::get('timeline'),
            'html' => \Request::get('html'),
            'project_image' => \Request::get('project_image')
        ]);

        return redirect(action('\App\Http\Controllers\ProjectsController@getIndex'));
    }

    /**
     * Edit form
     * @param $projectID
     * @return mixed
     */
    public function getEdit($projectID)
    {
        $project = Project::with('timeline')->find($projectID);

        return view('projects.form', [
            'project' => $project,
            'technologies' => Technology::get(),
            'timelines' => Timeline::get()
        ]);
    }

    /**
     * Saves a project
     * @param $projectID
     * @param ProjectFormRequest $request
     * @return mixed
     */
    public function postEdit($projectID, ProjectFormRequest $request)
    {
        $project = Project::find($projectID);

        if (\Request::has('end_date')) {
            $end_date = \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('end_date'));
        } else {
            $end_date = null;
        }

        $project->name = \Request::get('name');
        $project->url = \Request::get('URL');
        $project->start_date = \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('start_date'));
        $project->end_date = $end_date;
        $project->technologies = \Request::get('technologies');
        $project->timeline_id = \Request::get('timeline');
        $project->html = \Request::get('html');
        $project->project_image = \Request::get('project_image');

        $project->save();

        return redirect(action('\App\Http\Controllers\ProjectsController@getIndex'));
    }

    /**
     * Deletes a project
     * @param $projectID
     * @return mixed
     */
    public function getDelete($projectID)
    {
        Project::find($projectID)->delete();

        return redirect(action('\App\Http\Controllers\ProjectsController@getIndex'));
    }
}