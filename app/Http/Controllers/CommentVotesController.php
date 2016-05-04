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
    // TODO - sepereate into private functions to make it easier to debug
    /**
     * Stores a comment vote
     * @return mixed
     */
    public function store()
    {
        $comment = Comment::with([
            'blog',
            'votes' => function ($query) {
                $query->where('user_id', \Auth::user()->id);
            }
        ])->find(\Request::get('comment'));

        if (!empty($comment)) {
            if (\Auth::user()->id != $comment->user_id) {
                if (\Request::get('vote') == 1) {
                    $vote = 1;
                } else {
                    if (\Request::get('vote') == 0) {
                        $vote = -1;
                    } else {
                        return response('Unauthorized.', 401);
                    }
                }

                if ($comment->votes->count() != 0) {
                    $comment_vote = $comment->votes[0];

                    if ($comment_vote->vote != $vote) {
                        $comment->votes[0]->vote = $vote;

                        $comment->vote = $comment->vote + ($vote * 2);
                        $comment->push();
                    } else {
                        $comment->votes[0]->delete();
                        $comment->vote = $comment->vote - $vote;
                        $comment->save();
                    }
                } else {
                    CommentVote::create([
                        'user_id' => \Auth::user()->id,
                        'comment_id' => \Request::get('comment'),
                        'vote' => $vote
                    ]);

                    $comment->vote = $comment->vote + $vote;

                    $comment->save();
                }

                \Event::fire(new CommentUpdateVotes($comment));

                return response('Success');
            }


        }
        return response('Unauthorized.', 401);
    }
}
