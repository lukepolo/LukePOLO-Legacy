<div class="comment-area">
    <nav class="navbar">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">{{ $blog->comments->count() }} Comments</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            LukePOLO
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Your Profile</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    {!! Form::open(['id' => 'comment', 'class' => 'form-horizontal']) !!}
        <div class="form-group">
            <div class="col-sm-1">
                <img class="user-image img-responsive" src="{{ asset('/img/user.svg') }}">
            </div>
            <div class="col-sm-11">
                {!! Form::text('comment', null, ['id'=> 'comment_text','placeholder' => 'Start the discussion . . .']) !!}
            </div>
        </div>
        {!! Form::submit('Post', ['class' => 'pull-right comment-post btn btn-primary']) !!}
    {!! Form::close() !!}
    <div class="comments">
        @foreach($blog->comments->reverse() as $comment)
            <div class="comment-row row">
                <div class="col-sm-1">
                    <img class="user-image img-responsive" src="{{ asset('/img/user.svg') }}">
                </div>
                <div class="col-sm-11">
                    <div class="row">
                        <span class="user-name">
                            {{ $comment->user->name }}
                        </span>
                        <span class="timestamp">
                            • {{ $comment->created_at->diffForHumans() }}
                        </span>
                    </div>
                    <div class="row comment">
                        {{ $comment->comment }}
                    </div>
                    <div class="row comment-footer">
                        1000 <i fa="fa fa-chevron-up"></i> | <i fa="fa fa-chevron-down"></i> • <span>Reply</span> • <span>Share</span>
                    </div>
                </div>
            </div>
            <hr>
        @endforeach
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#comment').submit(function(e)
        {
            var comment = $('#comment_text');

            e.preventDefault();
            $.post("{{ action('\App\Http\Controllers\CommentsController@store') }}",
            {
                comment: comment.val(),
                blog_id: "{{ $blog->id }}"
            });
            comment.val('');
        });
    });
</script>