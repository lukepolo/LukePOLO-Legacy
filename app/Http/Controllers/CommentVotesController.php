<?php

namespace App\Http\Controllers;

use App\Events\CommentUpdateVotes;
use App\Models\Mongo\Comment;
use App\Models\Mongo\CommentVote;

/**
 * Class CommentVotesController
 * @package App\Http\Controllers
 */
class CommentVotesController extends Controller
{
    /**
     * Stores a comment vote
     * @return mixed
     */
    public function store()
    {
        if (!empty($comment = Comment::find(\Request::get('comment')))) {
            if (\Auth::user()->id != $comment->user_id) {

                $commentVote = CommentVote::firstOrCreate([
                    'user_id' => \Auth::user()->id,
                    'comment_id' => \Request::get('comment'),

                ]);
                $commentVote->vote = \Request::get('vote');
                $commentVote->save();

                \Event::fire(new CommentUpdateVotes($comment));

                return response('Success');
            }
        }
        return response('Unauthorized.', 401);
    }
}
