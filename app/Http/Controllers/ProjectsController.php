<?php

namespace app\Http\Controllers;

use \App\Models\Mongo\Projects;

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
        return view('projects.create');
    }
}