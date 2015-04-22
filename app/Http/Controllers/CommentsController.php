<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Comment;

class CommentsController extends Controller
{
    public function store()
    {
        Comment::create([
            'user_id' => \Auth::user()->id,
            'blog_id' => \Request::get('blog_id'),
            'comment' => \Request::get('comment'),
            'been_moderated' => \Auth::user()->role == 'admin' ? true : null,
            'parent_id' => \Request::get('reply_to'),
            'vote' => 0
        ]);

        return;
    }

    public function destroy($comment_id)
    {
        $comment = Comment::find($comment_id);
        if(\Auth::user()->role == 'admin' || \Auth::user()->id == $comment->user_id)
        {
            $comment->delete();
            return;
        }
        else
        {
            return response('Unauthorized.', 401);
        }
    }
}
