<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Project;
use App\Models\Mongo\Technology;
use App\Models\Mongo\Timeline;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Main view for site
     * @return mixed
     */
    public function index()
    {
        return view('home', [
            'projects' => Project::with(['timeline', 'technologies'])->orderBy('start_date', 'desc')->get(),
            'technologies' => Technology::orderBy('name')->get()->keyBy('_id'),
            'timelines' => Timeline::get()
        ]);
    }
}
