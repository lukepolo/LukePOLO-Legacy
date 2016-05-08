<div data-id="{{ $comment->id }}" class="row comment-row">
    <div class="col-xs-1">
        <img class="pull-right img-responsive" src="{{ !empty($comment->user->profile_img) ? $comment->user->profile_img : asset('/img/user.svg') }}">
    </div>
    <div class="col-xs-11 reply-area">
        <div class="row">
            <span class="user-name">
                {{ $comment->user->first_name }}
                {{ $comment->user->last_name }}
            </span>
            <span class="timestamp" title="{{ $comment->created_at->toW3cString() }}"> </span>
        </div>
        <div class="row comment">
            {{ $comment->comment }}
        </div>
        <div class="row comment-footer">
            @if(!\Auth::check() || $comment->user_id != \Auth::user()->id)
                <span class="voting">
                    <?php
                        switch($comment->getCurrentUserVote()) {
                            case 1:
                                $voteClass = 'up-selected';
                                break;
                            case -1:
                                $voteClass = 'down-selected';
                                break;
                            default:
                                $voteClass = '';
                                break;
                        }
                    ?>
                    <i data-id="{{ $comment->id }}" class="js-up-vote-count fa fa-thumbs-o-up @if(\Auth::check()) up-vote @endif {{ $voteClass }}"> {{ $comment->getUpVotes() }} </i> |
                    <i data-id="{{ $comment->id }}" class="js-down-vote-count fa fa-thumbs-o-down @if(\Auth::check()) down-vote @endif {{ $voteClass }}"> {{ $comment->getDownVotes() }}</i>
                </span>
                @if(\Auth::check())
                    &bull; <span data-id="{{ $comment->id }}" class="btn-link reply">Reply</span>
                @endif
            @else
                &bull; <span data-id="{{ $comment->id }}" class="btn-link edit">Edit</span>
            @endif
            @if(\Auth::check() && (\Auth::user()->role == 'admin' || $comment->user_id == \Auth::user()->id))
                &bull; <span data-id="{{ $comment->id }}" class="btn-link delete">Delete</span>
            @endif
        </div>
        @foreach($comment->replies as $reply)
            @include('blog.comments.comment', [
               'comment' => $reply
           ])
        @endforeach
    </div>
</div>