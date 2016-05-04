<?php

namespace App\Http\Controllers;

use App\Events\CommentCreated;
use App\Events\CommentDeleted;
use App\Events\CommentUpdated;
use App\Models\Mongo\Blog;
use App\Models\Mongo\Comment;

/**
 * Class CommentsController
 * @package App\Http\Controllers
 */
class CommentsController extends Controller
{
    /**
     * Shows a comment based on the id
     * @param $commentID
     * @return mixed
     */
    public function show($commentID)
    {
        $comment = Comment::find($commentID);

        if (!empty($comment)) {
            return view('blog.comments.comment', ['comment' => $comment])->render();
        } else {
            return response('Unauthorized.', 401);
        }
    }

    /**
     * Stores a comment
     * @return mixed
     */
    public function store()
    {
        $commentText = trim(\Request::get('comment'));

        $blog = Blog::find(\Request::get('blog_id'));
        if (!empty($commentText) && !empty($blog)) {
            $comment = Comment::create([
                'user_id' => \Auth::user()->id,
                'blog_id' => \Request::get('blog_id'),
                'comment' => $commentText,
                'been_moderated' => \Auth::user()->role == 'admin' ? true : null,
                'parent_id' => \Request::get('reply_to'),
                'vote' => 0
            ]);
            
            \Event::fire(new CommentCreated($comment));

            return response('Success');
        } else {
            return response('Unauthorized.', 401);
        }
    }

    /**
     * Deletes a comment
     * @param $commentID
     * @return mixed
     */
    public function destroy($commentID)
    {
        $comment = Comment::with('replies')->with('blog')->find($commentID);

        if (\Auth::user()->role == 'admin' || \Auth::user()->id == $comment->user_id) {


            \Event::fire(new CommentDeleted($comment));

            $this->recursiveDelete($comment);

            $comment->delete();

            return response('Success');
        } else {
            return response('Unauthorized.', 401);
        }
    }

    /**
     * Updates the comment
     * @param $commentID
     * @return mixed
     */
    public function update($commentID)
    {
        $commentText = trim(\Request::get('comment'));

        $comment = Comment::with('blog')->find($commentID);

        if (!empty($commentText) && \Auth::user()->id == $comment->user_id) {
            $comment->comment = $commentText;

            $comment->been_moderated = null;

            $comment->save();

            \Event::fire(new CommentUpdated($comment));

            return response('Success');
        } else {
            return response('Unauthorized.', 401);
        }
    }

    /**
     * Deletes sub comments of a comment
     * @param $comment
     */
    private function recursiveDelete($comment)
    {
        foreach ($comment->replies as $reply) {

            \Event::fire(new CommentCreated($reply));

            $this->recursiveDelete(Comment::with('replies')->with('blog')->find($reply->id));

            $reply->delete();
        }
    }
}
