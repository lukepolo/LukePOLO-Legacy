<?php

namespace App\Events;

use App\Models\Mongo\Comment;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CommentUpdated extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $comment;
    public $room;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->room = route('blog/view', $comment->blog->link_name);
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [
            'update_comment'
        ];
    }
}
