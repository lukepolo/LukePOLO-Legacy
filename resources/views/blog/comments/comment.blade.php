<div data-id="{{ $comment->id }}" class="comment-row row">
    <div class="col-xs-1">
        <img class="pull-right img-responsive" src="{{ empty($comment->user->profile_img) === false ? $comment->user->profile_img : asset('/img/user.svg') }}">
    </div>
    <div class="col-xs-11 reply-area">
        <div class="row">
            <span class="user-name">
                {{ $comment->user->first_name }}
                {{ $comment->user->last_name }}
            </span>
            <span class="timestamp" title="{{ $comment->created_at->toW3cString() }}"> </span>
            <span class="reply_to">
                @if(isset($reply_to) === true)
                    <small>
                        <i class="fa fa-reply"></i>
                        {{ $reply_to }}
                    </small>
                @endif
            </span>
        </div>
        <div class="row comment">
            {{ $comment->comment }}
        </div>
        <div class="row comment-footer">
            <span class="up-votes">{{ $comment->vote }}</span> votes
            @if(\Auth::check())
                @if($comment->user_id != \Auth::user()->id)
                    <span class="voting">
                        @if($comment->votes->count() == 1)
                            <?php
                                $votes = $comment->votes->keyBy('user_id')->toArray();
                            ?>
                            @if(array_key_exists(\Auth::user()->id, $votes))
                                @if($votes[\Auth::user()->id]['vote'] == 1)
                                    <?php $vote_class = 'up-selected'; ?>
                                @else
                                    <?php $vote_class = 'down-selected'; ?>
                                @endif
                            @else
                                <?php $vote_class = ''; ?>
                            @endif
                        @else
                            <?php $vote_class = ''; ?>
                        @endif
                        <i data-id="{{ $comment->id }}" class="fa fa-thumbs-o-up up-vote {{ $vote_class }}"></i> |
                        <i data-id="{{ $comment->id }}" class="fa fa-thumbs-o-down down-vote {{ $vote_class }}"></i>
                    </span>
                    &bull; <span data-id="{{ $comment->id }}" class="btn-link reply">Reply</span>
                @else
                    &bull; <span data-id="{{ $comment->id }}" class="btn-link edit">Edit</span>
                @endif
                @if(\Auth::user()->role == 'admin' || $comment->user_id == \Auth::user()->id)
                    &bull; <span data-id="{{ $comment->id }}" class="btn-link delete">Delete</span>
                @endif
            @endif
        </div>
        @foreach($comment->replies as $reply)
            @include('blog.comments.comment', [
               'comment' => $reply,
               'reply_to' => $comment->user->first_name.' '.$comment->user->last_name
           ])
        @endforeach
    </div>
</div>