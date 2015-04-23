<div class="comment-area">
    <nav class="navbar">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="#">{{ $blog->comments->count() }} Comments</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    @if(\Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ \Auth()->user()->first_name }}
                            {{ \Auth()->user()->last_name }}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ action('Auth\AuthController@getLogout') }}">Logout</a></li>
                        </ul>
                    </li>
                    @else
                        <li>
                            <div class="navbar-text">
                                Login to comment :
                            </div>
                        </li>
                        <li>
                            <a href="{{ action('\App\Http\Controllers\Auth\AuthController@getService', ['google']) }}">
                                <i class="fa fa-google"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ action('\App\Http\Controllers\Auth\AuthController@getService', ['github']) }}">
                                <i class="fa fa-github"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ action('\App\Http\Controllers\Auth\AuthController@getService', ['facebook']) }}">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ action('\App\Http\Controllers\Auth\AuthController@getService', ['linkedin']) }}">
                                <i class="fa fa-linkedin"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ action('\App\Http\Controllers\Auth\AuthController@getService', ['twitter']) }}">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a href="{{ action('\App\Http\Controllers\Auth\AuthController@getService', ['reddit']) }}">
                                <i class="fa fa-reddit"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @if(\Auth::check())
        {!! Form::open(['class' => 'comment-form form-horizontal']) !!}
            <div class="form-group">
                <div class="col-sm-1">
                    <img class="pull-right user-image img-responsive" src="{{ empty(\Auth::user()->profile_img) === false ?  \Auth::user()->profile_img : asset('/img/user.svg') }}">
                </div>
                <div class="col-sm-11">
                    {!! Form::text('comment', null, ['class'=> 'comment-text form-control','placeholder' => $blog->comments->count() == 0 ? 'Start the discussion . . .' : 'Join the discussion . . .' ]) !!}
                </div>
            </div>
            {!! Form::submit('Post', ['class' => 'pull-right comment-post btn btn-primary']) !!}
        {!! Form::close() !!}
    @endif
    <div class="comments">
        @foreach($blog->comments->reverse() as $comment)
            @include('blog.comments.comment', [
                'comment' => $comment
            ])
            <hr>
        @endforeach
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        socket.on('create_comment', function(comment_id, parent_id)
        {
            $.get('{{ action('\App\Http\Controllers\CommentsController@show', [null]) }}/' + comment_id, function(html)
            {
                if(parent_id)
                {
                    $('.comment-row[data-id="' + parent_id + '"]').find('.comment-footer').last().after(html);
                }
                else
                {
                    $('.comments').prepend(html);
                }
            });
        });

        socket.on('update_comment', function(comment_id, comment)
        {
            $('.comment-row[data-id="' + comment_id + '"]').find('.comment').first().html(comment);
        });

        socket.on('delete_comment', function(comment_id)
        {
            $('.comment-row[data-id="' + comment_id + '"]').remove();
        });

        socket.on('update_votes', function(comment_id, votes)
        {
            console.log(comment_id);
            $('.comment-row[data-id="' + comment_id + '"]').find('.comment-footer .up-votes').first().html(votes);
        });

        $(document).on('submit', '.comment-form', function(e)
        {
            e.preventDefault();

            var form = $(this);
            var comment = $(this).find('.comment-text');

            $.post("{{ action('\App\Http\Controllers\CommentsController@store') }}",
            {
                comment: comment.val(),
                blog_id: "{{ $blog->id }}",
                reply_to : $(form).data('reply-to')
            }).success(function()
            {
                if($(form).data('reply-to'))
                {
                    $(form).remove();
                }
                else
                {
                    comment.val('');
                }
            });
        });

        $(document).on('submit', '.comment-edit-form', function(e)
        {
            e.preventDefault();

            var form = $(this);
            var comment = form.find('.comment-text');

            $.ajax({
                url: "{{ action('\App\Http\Controllers\CommentsController@update', null) }}/" + $(this).data('id'),
                type: 'PUT',
                data: {
                    comment : comment.val()
                }
            }).success(function()
            {
                $(form).remove();
            });
        });

        $(document).on('click', '.delete', function(e)
        {
            $.ajax({
                url: "{{ action('\App\Http\Controllers\CommentsController@destroy', null) }}/" + $(this).data('id'),
                type: 'DELETE'
            });
        });

        $(document).on('click', '.up-vote', function()
        {
            var span = this;
            $.post("{{ action('\App\Http\Controllers\CommentVotesController@store') }}",
            {
                comment: $(this).data('id'),
                vote : 1
            }).success(function()
            {
                $(span).parent().find('.down-selected').removeClass('down-selected');
                $(span).addClass('up-selected');
            });
        });

        $(document).on('click', '.down-vote', function()
        {
            var span = this;
            $.post("{{ action('\App\Http\Controllers\CommentVotesController@store') }}",
            {
                comment: $(this).data('id'),
                vote: 0
            }).success(function()
            {
                $(span).parent().find('.up-selected').removeClass('up-selected');
                $(span).addClass('down-selected');
            });
        });

        $(document).on('click', '.reply', function()
        {
            if(!$(this).parent().after().next().is('form'))
            {
                var comment_form = $('.comment-form').first().clone().attr('data-reply-to', $(this).data('id'));

                comment_form.find('.comment-post').val('Reply').after('<div class="pull-right btn btn-danger cancel">Cancel</div>');

                $(this).parent().after(comment_form);
            }
        });

        $(document).on('click', '.edit', function()
        {
            if(!$(this).parent().after().next().is('form'))
            {
                var comment_form = $('.comment-form').first().clone().attr('data-reply-to', $(this).data('id'));

                comment_form.data('id', $(this).data('id'))
                comment_form.addClass('comment-edit-form').removeClass('comment-form');
                comment_form.find('.comment-text').val($(this).parent().prev().text().trim());
                comment_form.find('.comment-post').val('Update').after('<div class="pull-right btn btn-danger cancel">Cancel</div>');

                $(this).parent().after(comment_form);
            }
        });

        $(document).on('click', '.cancel', function()
        {
            $(this).closest('form').remove();
        });
    });
</script>