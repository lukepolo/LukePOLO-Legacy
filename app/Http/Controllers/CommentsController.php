<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Comment;

class CommentsController extends Controller
{
    public function store()
    {
        $comment = Comment::create([
            'user_id' => \Auth::user()->id,
            'blog_id' => \Request::get('blog_id'),
            'comment' => \Request::get('comment'),
            'been_moderated' => false,
            'parent_id' => \Request::get('reply_to')
        ]);

        return;
    }

    public function destroy()
    {
        if(\Auth::user()->role == 'admin')
        {
            Comment::find(\Request::get('comment'))->delete();
            return;
        }
        else
        {
            return response('Unauthorized.', 401);
        }
    }
}
