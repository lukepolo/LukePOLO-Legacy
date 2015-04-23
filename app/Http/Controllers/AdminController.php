<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Blog;
use App\Models\Mongo\Comment;

class AdminController extends Controller
{
    public function getIndex()
    {
        return view('admin.index', [
            'comments' => Comment::with('blog')->whereNull('been_moderated')->get()
        ]);
    }

    public function getCreate()
    {
        return view('admin.create');
    }

    public function getBlogs()
    {
        return view('admin.blogs', [
            'blogs' => Blog::get()
        ]);
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

    public function postMarkRead()
    {
        $comment = Comment::find(\Request::get('comment_id'));

        $comment->been_moderated = true;

        $comment->save();

        return response('Success');
    }

    public function getComment($comment_id)
    {
        $comment = Comment::find($comment_id);
        if(empty($comment) === false)
        {
            return view('admin.comment', ['comment' => $comment])->render();
        }
    }
}