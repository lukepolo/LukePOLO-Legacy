<?php

namespace App\Events;

use App\Models\Mongo\Comment;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CommentCreated extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $comment;
    public $rooms = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->rooms = [
            route('blog/view', $comment->blog->link_name),
            env('ADMIN_ROOM')
        ];
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [
            'create_comment'
        ];
    }
}
