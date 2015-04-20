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
            'comment' => \Request::get('comment')
        ]);

        return response($comment->id);
    }
}
