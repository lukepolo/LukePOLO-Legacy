<?php

namespace App\Http\Controllers;


/**
 * Class ResumeController
 * @package App\Http\Controllers
 */
class ResumeController extends Controller
{
    /**
     * Main view for the resume
     * @return mixed
     */
    public function getIndex()
    {
        return view('resume');
    }
}