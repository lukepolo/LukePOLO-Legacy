<?php

namespace App\Http\Controllers;


class ResumeController extends Controller
{
    public function getIndex()
    {
        return view('resume');
    }
}