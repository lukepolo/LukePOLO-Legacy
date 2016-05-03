<?php

namespace App\Http\Controllers;

use App\Models\Mongo\Blog;
use App\Models\Mongo\Comment;

class CommentsController extends Controller
{
    public function show($comment_id)
    {
        $comment = Comment::find($comment_id);
        if (empty($comment) === false) {
            return view('blog.comments.comment', ['comment' => $comment])->render();
        } else {
            return response('Unauthorized.', 401);
        }
    }

    public function store()
    {
        $comment_text = trim(\Request::get('comment'));

        $blog = Blog::find(\Request::get('blog_id'));
        if (empty($comment_text) === false && empty($blog) === false) {
            $comment = Comment::create([
                'user_id' => \Auth::user()->id,
                'blog_id' => \Request::get('blog_id'),
                'comment' => $comment_text,
                'been_moderated' => \Auth::user()->role == 'admin' ? true : null,
                'parent_id' => \Request::get('reply_to'),
                'vote' => 0
            ]);

            \Emitter::emit('create_comment', route('blog/view', $blog->link_name), [
                'comment_id' => $comment->id,
                'parent_id' => \Request::get('reply_to')
            ]);

            return response('Success');
        } else {
            return response('Unauthorized.', 401);
        }
    }

    public function destroy($comment_id)
    {
        $comment = Comment::with('replies')->with('blog')->find($comment_id);

        if (\Auth::user()->role == 'admin' || \Auth::user()->id == $comment->user_id) {
            \Emitter::emit('delete_comment', route('blog/view', $comment->blog->link_name), [
                'comment_id' => $comment->id
            ]);

            $this->recursive_delete($comment);

            $comment->delete();

            return response('Success');
        } else {
            return response('Unauthorized.', 401);
        }
    }

    public function update($comment_id)
    {
        $comment_text = trim(\Request::get('comment'));

        $comment = Comment::with('blog')->find($comment_id);

        if (empty($comment_text) === false && \Auth::user()->id == $comment->user_id) {
            $comment->comment = $comment_text;

            $comment->been_moderated = null;

            \Emitter::emit('update_comment', route('blog/view', $comment->blog->link_name), [
                'comment_id' => $comment->id,
                'comment' => $comment->comment
            ]);

            $comment->save();
            return response('Success');
        } else {
            return response('Unauthorized.', 401);
        }
    }

    public function recursive_delete($comment)
    {
        foreach ($comment->replies as $reply) {
            \Emitter::emit('delete_comment', null, [
                'comment_id' => $reply->id
            ]);

            $this->recursive_delete(Comment::with('replies')->with('blog')->find($reply->id));

            $reply->delete();
        }
    }
}
