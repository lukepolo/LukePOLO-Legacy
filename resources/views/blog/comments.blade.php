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
                <a class="navbar-brand" href="#">0 Comments</a>
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
    <div class="comments">
        @foreach($blog->comments as $comment)
            {{ Dump($comment) }}
        @endforeach
    </div>
    {!! Form::open(['id' => 'comment', 'class' => 'form-horizontal']) !!}
        <div class="form-group">
            <div class="col-sm-1">
                <img class="user-image img-responsive" src="{{ asset('/img/user.svg') }}">
            </div>
            <div class="col-sm-11">
                {!! Form::text('Start_the_discussion . . .') !!}
            </div>
        </div>
        {!! Form::submit('Post') !!}
    {!! Form::close() !!}
</div>
<script type="text/javascript">
    $(document).ready(function()
    {
        $('#comment').submit(function(e)
        {
            e.preventDefault();
            $.post("{{ action('\App\Http\Controllers\CommentsController@store') }}",
            {
                comment: $('#comment').find('input').val(),
                blog_id: "{{ $blog->id }}"
            });
        });
    });
</script>