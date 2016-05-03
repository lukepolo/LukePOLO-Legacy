<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectFormRequest;
use App\Models\Mongo\Project;
use App\Models\Mongo\Technology;
use App\Models\Mongo\Timeline;

class ProjectsController extends Controller
{
    public function getIndex()
    {
        return view('projects', [
            'projects' => Project::with('timeline')->orderBy('start_date', 'dsc')->get()
        ]);
    }

    public function getCreate()
    {
        return view('projects.form', [
            'technologies' => Technology::get(),
            'timelines' => Timeline::get()
        ]);
    }

    public function postCreate(ProjectFormRequest $request)
    {
        if (\Request::get('end_date') != '') {
            $end_date = \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('end_date'));
        } else {
            $end_date = null;
        }

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

    public function getEdit($project_id)
    {
        $project = Project::with('timeline')->find($project_id);

        return view('projects.form', [
            'project' => $project,
            'technologies' => Technology::get(),
            'timelines' => Timeline::get()
        ]);
    }

    public function postEdit($project_id, ProjectFormRequest $request)
    {
        $project = Project::find($project_id);

        if (\Request::get('end_date') != '') {
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

    public function getDelete($project_id)
    {
        Project::find($project_id)->delete();

        return redirect(action('\App\Http\Controllers\ProjectsController@getIndex'));
    }
}