<div class="comment-row row">
    <div class="col-sm-1">
        <img class="pull-right img-responsive" src="{{ empty($comment->user->profile_img) === false ? $comment->user->profile_img : asset('/img/user.svg') }}">
    </div>
    <div class="col-sm-11">
        <div class="row">
            <span class="user-name">
                {{ $comment->user->first_name }}
                {{ $comment->user->last_name }}
            </span>
            <span class="timestamp">
                • {{ $comment->created_at->diffForHumans() }}
            </span>
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
            <span class="up-votes">{{ $comment->vote }}</span>
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
                        <i data-id="{{ $comment->id }}" class="fa fa-chevron-up up-vote {{ $vote_class }}"></i> |
                        <i data-id="{{ $comment->id }}" class="fa fa-chevron-down down-vote {{ $vote_class }}"></i>
                    </span>
                    • <span data-id="{{ $comment->id }}" class="btn-link reply">Reply</span>
                @else
                    • <span data-id="{{ $comment->id }}" class="btn-link edit">Edit</span>
                    @if(\Auth::user()->role == 'admin' || $comment->user_id == \Auth::user()->id)
                        • <span data-id="{{ $comment->id }}" class="btn-link delete">Delete</span>
                    @endif
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