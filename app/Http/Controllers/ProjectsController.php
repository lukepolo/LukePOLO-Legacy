<?php

namespace App\Http\Controllers;

use \App\Models\Mongo\Projects;
use \App\Models\Mongo\Technologies;

class ProjectsController extends Controller
{
    public function getIndex()
    {
        return view('projects',[
            'projects' => Projects::get()
        ]);
    }

    public function getCreate()
    {
        return view('projects.form', [
            'technologies' => Technologies::get()
        ]);
    }

    public function getEdit($project_id)
    {
        $project = Projects::find($project_id);

        return view('projects.form', [
            'project' => $project,
            'technologies' => Technologies::get()
        ]);

    }

    public function postEdit($project_id)
    {
        $project = Projects::find($project_id);

        $project->name = \Request::get('name');
        $project->start_date = \Request::get('start_date');
        $project->end_date = \Request::get('end_date');
        $project->technologies = \Request::get('technologies');
        $project->html = \Request::get('html');
        $project->project_image = \Request::get('project_image');

        $project->save();

        return redirect(action('\App\Http\Controllers\ProjectsController@getIndex'));
    }


    public function postCreate()
    {
        Projects::create([
            'name' => \Request::get('name'),
            'start_date' => \Request::get('start_date'),
            'end_date' => \Request::get('end_date'),
            'technologies' => \Request::get('technologies'),
            'html' => \Request::get('html'),
            'project_image' => \Request::get('project_image')
        ]);

        return redirect(action('\App\Http\Controllers\ProjectsController@getIndex'));
    }
}