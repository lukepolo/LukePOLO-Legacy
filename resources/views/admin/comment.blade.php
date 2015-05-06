@if(\Auth::user()->id != $comment->user_id)
    <div data-id="{{ $comment->id }}" class="comment-row">
        <div class="row">
            <div class="col-xs-2">
                <img class="pull-right img-responsive" src="{{ empty($comment->user->profile_img) === false ? $comment->user->profile_img : asset('/img/user.svg') }}">
            </div>
            <div class="col-xs-10">
                <div class="row">
                    <span class="user-name">
                        {{ $comment->user->first_name }}
                        {{ $comment->user->last_name }}
                    </span>
                    <span class="timestamp">
                        &bull; {{ $comment->created_at->diffForHumans() }}
                    </span>
                    <span data-id="{{ $comment->id }}" class="mark-read pull-right btn btn-xs btn-primary">
                        Mark As Read
                    </span>
                </div>
                <div class="row comment">
                    {{ $comment->comment }}
                </div>
                <div class="row comment-footer">
                    <span class="up-votes">{{ $comment->vote }}</span>
                    &bull; <span data-blog-id="{{ $comment->blog->id }}" data-id="{{ $comment->id }}" class="btn-link reply">Reply</span>
                    &bull; <span data-id="{{ $comment->id }}" class="btn-link delete">Delete</span>
                    &bull; <a href="{{ route('blog/view', $comment->blog->link_name)  }}"> Vew @ {{ $comment->blog->link_name }}</a>
                </div>
            </div>
        </div>
        <div class="row">
            <hr>
        </div>
    </div>
@endif