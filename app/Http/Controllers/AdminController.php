<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Blogs;
use App\Models\Mongo\Comments;

class AdminController extends Controller
{
    public function getIndex()
    {
        return view('admin.index');
    }

    public function getCreate()
    {
        return view('admin.create');
    }

    public function getBlogs()
    {
        return view('admin.blogs', [
            'blogs' => Blogs::get()
        ]);
    }

    public function getActiveUsers()
    {
        return response()->json(\LaravelAnalytics::getActiveUsers());
    }

    public function getVisits()
    {
        $visitors =  \LaravelAnalytics::getVisitorsAndPageViews(7);

        $analytics = null;
        foreach($visitors as $visitor)
        {
            $analytics['labels'][] = $visitor['date']->toDateString();
            $analytics['visitors'][] = $visitor['visitors'];
            $analytics['views'][] = $visitor['pageViews'];
        }

        return response()->json($analytics);
    }
}