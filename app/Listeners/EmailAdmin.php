<?php

namespace App\Listeners;

use App\Events\CommentCreated;
use Illuminate\Mail\Message;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\Queue;

/**
 * Class EmailAdmin
 * @package App\Listeners
 */
class EmailAdmin
{
    /**
     * Handle the event.
     *
     * @param  CommentCreated  $event
     * @return void
     */
    public function handle(CommentCreated $event)
    {
        \Mail::queue('emails.newComment', [
            'comment' => $event->comment->load(['user', 'blog'])
        ], function(Message $message) {
            $message->to('Luke@LukePOLO.com');
            $message->subject('New Comment');
        });
    }
}
