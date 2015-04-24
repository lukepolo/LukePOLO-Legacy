<?php

namespace App\Http\Controllers;

use \App\Models\Mongo\Project;
use \App\Models\Mongo\Technology;

class ProjectsController extends Controller
{
    public function getIndex()
    {
        return view('projects',[
            'projects' => Project::orderBy('start_date', 'dsc')->get()
        ]);
    }

    public function getCreate()
    {
        return view('projects.form', [
            'technologies' => Technology::get()
        ]);
    }

    public function getEdit($project_id)
    {
        $project = Project::find($project_id);

        return view('projects.form', [
            'project' => $project,
            'technologies' => Technology::get()
        ]);
    }

    public function postEdit($project_id)
    {
        $project = Project::find($project_id);

        $project->name = \Request::get('name');
        $project->start_date = \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('start_date'));
        $project->end_date = \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('end_date'));
        $project->technologies = \Request::get('technologies');
        $project->html = \Request::get('html');
        $project->project_image = \Request::get('project_image');

        $project->save();

        return redirect(action('\App\Http\Controllers\ProjectsController@getIndex'));
    }


    public function postCreate()
    {
        Project::create([
            'name' => \Request::get('name'),
            'start_date' => \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('start_date')),
            'end_date' => \Carbon\Carbon::createFromFormat('m-d-Y', \Request::get('end_date')),
            'technologies' => \Request::get('technologies'),
            'html' => \Request::get('html'),
            'project_image' => \Request::get('project_image')
        ]);

        return redirect(action('\App\Http\Controllers\ProjectsController@getIndex'));
    }

    public function getDelete($project_id)
    {
        Project::find($project_id)->delete();

        return redirect(action('\App\Http\Controllers\ProjectsController@getIndex'));
    }
}