<?php

namespace App\Http\Controllers;

use \App\Models\Mongo\Timeline;

class WelcomeController extends Controller
{
	public function index()
	{
        $timelines = Timeline::get();

		return view('welcome', ['timelines' => $timelines]);
	}
}
