@extends('layouts.admin')

@section('content')
    <div class="col-md-6 admin-comments">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    User Comments
                    <span class="pull-right unread label @if($comments->count() == 0) label-default @else label-warning @endif">
                         <span class="count">{{ $comments->count() }}</span> Messages
                    </span>
                </h3>
            </div>
            <div class="panel-body">
                @if($comments->count()  == 0)
                    <div class="text-center">
                        Go Enjoy Your Day!
                    </div>
                @else
                    {!! Form::open(['class' => 'comment-form form-horizontal hide']) !!}
                        <div class="form-group">
                            <div class="col-sm-2">
                                <img class="pull-right user-image img-responsive" src="{{ empty(\Auth::user()->profile_img) === false ?  \Auth::user()->profile_img : asset('/img/user.svg') }}">
                            </div>
                            <div class="col-sm-10">
                                <div class="row">
                                    {!! Form::text('comment', null, ['class'=> 'comment-text form-control','placeholder' =>'Reply . . . ']) !!}
                                </div>
                            </div>
                        </div>
                        {!! Form::submit('Post', ['class' => 'pull-right comment-post btn btn-primary']) !!}
                        <div class="pull-right btn btn-danger cancel">Cancel</div>
                    {!! Form::close() !!}
                    @foreach($comments->reverse() as $comment)
                        @include('admin.comment', ['comment' => $comment])
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Active Users</h3>
                </div>
                <div class="panel-body">
                    <div class="active-users text-center"></div>
                    <div class="active-user-locations">
                        <table class="table table-striped">
                            <thead>
                                <th>Location</th>
                                <th>User Count</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Visitors</h3>
                </div>
                <div class="visitor-chart" class="panel-body">
                    <canvas id="chart"></canvas>
                </div>
                <div class="popular-pages">
                    <table class="table table-striped">
                        <thead>
                        <th>URL</th>
                        <th>Views</th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function()
        {
            socket.emit('get_users');

            socket.on('create_comment', function(comment_id)
            {
                $.get('{{ action('AdminController@getComment', [null]) }}/' + comment_id, function(html)
                {
                    $('.admin-comments .panel-body').prepend(html);
                    update_count();
                });
            });

            socket.on('update_comment', function(comment_id, comment)
            {
                if($('div[data-id="'+comment_id+'"]').length != 0)
                {
                    $('div[data-id="'+comment_id+'"]').find('.comment').html(comment);
                }
                else
                {
                    $.get('{{ action('AdminController@getComment', [null]) }}/' + comment_id, function(html)
                    {
                        $('.admin-comments .panel-body').prepend(html);
                    });
                }
                update_count();
            });

            socket.on('delete_comment', function(comment_id)
            {
                $('div[data-id="'+comment_id+'"]').remove();
                update_count();
            });

            socket.on('users', function(users)
            {
                // Minus one because we know that is me!
                var user_count = Object.keys(users).length - 1;

                if(user_count > 0)
                {
                    $('.active-users').html(user_count);
                    
                    var locations = {};
                    $.each(users, function (session_id, location)
                    {
                        if ('{{ \Session::getId() }}' != session_id)
                        {
                            if (locations[location])
                            {
                                locations[location]++;
                            }
                            else
                            {
                                locations[location] = 1;
                            }
                        }
                    });

                    $('.active-user-locations table tbody').children().remove();
                    
                    $.each(locations, function (location, user_count)
                    {
                        $('.active-user-locations table tbody').append('<tr>' +
                        '<td>' + location + '</td>' +
                        '<td>' + user_count + '</td>' +
                        '</tr>');
                    });
                }
                else
                {
                $('.active-users').html(0);
                    $('.active-user-locations table tbody').html('<td colspan="2" class="text-center"><h3>No users currently online!<h3></td>');
                }
            });

            $(document).on('click', '.cancel', function()
            {
                $(this).closest('form').remove();
            });

            $(document).on('click', '.reply', function()
            {
                if(!$(this).parent().after().next().is('form'))
                {
                    var comment_form = $('.comment-form').first().clone().attr('data-reply-to', $(this).data('id')).attr('data-blog-id', $(this).data('blog-id'));

                    comment_form.removeClass('hide');

                    $(this).parent().after(comment_form);

                    comment_form.find('.comment-text').first().focus();
                }
            });

            $(document).on('click', '.delete', function(e)
            {
                $.ajax({
                    url: "{{ action('CommentsController@destroy', null) }}/" + $(this).data('id'),
                    type: 'DELETE'
                });

                $(this).closest('.comment-row').remove();

                update_count();
            });

            $(document).on('submit', '.comment-form', function(e)
            {
                e.preventDefault();

                var form = $(this);
                var comment = $(this).find('.comment-text');
                $.post("{{ action('CommentsController@store') }}",
                {
                    comment: comment.val(),
                    blog_id: $(form).data('blog-id'),
                    reply_to : $(form).data('reply-to')
                }).success(function()
                {
                    if($(form).data('reply-to'))
                    {
                        $(form).remove();
                    }

                    mark_read($(form).data('reply-to'));
                });
            });

            $(document).on('click', '.mark-read', function(e)
            {
                mark_read($(this).data('id'));
                update_count();
            });
            $.get("{{ action('AdminController@getPopularPages') }}", function(popular_pages)
            {
                $.each(popular_pages, function()
                {
                    $('.popular-pages table tbody').append('<tr><td><a target="_blank" href="'+ this.url +'">' + this.url + '</a></td><td>' + this.pageViews + '</td></tr>');
                });
            });

            $.get("{{ action('AdminController@getVisits') }}", function(visits)
            {
                var analytics = visits;
                var data = {
                    labels: analytics.labels,
                    datasets: [
                        {
                            label: "Visitors",
                            fillColor: "rgba(151,187,205,0.2)",
                            strokeColor: "rgba(151,187,205,1)",
                            pointColor: "rgba(151,187,205,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(151,187,205,1)",
                            data: analytics.visitors
                        },
                        {
                            label: "Views",
                            fillColor: "rgba(220,220,220,0.2)",
                            strokeColor: "rgba(220,220,220,1)",
                            pointColor: "rgba(220,220,220,1)",
                            pointStrokeColor: "#fff",
                            pointHighlightFill: "#fff",
                            pointHighlightStroke: "rgba(220,220,220,1)",
                            data: analytics.views
                        }
                    ]
                };
                var chart = new Chart($("#chart").get(0).getContext("2d")).Line(data,{
                    bezierCurve : true,
                    responsive: true,
                    scaleShowVerticalLines: false
                });
            });

            $(document).keyup(function(e) {

                if (e.keyCode == 27)
                {
                    $('input:focus').closest('form').find('.cancel').click();
                }
            });
        });

        function mark_read(comment_id)
        {
            $.post("{{ action('AdminController@postMarkRead') }}",
            {
                comment_id: comment_id
            }).success(function()
            {
                $('.comment-row[data-id="' + comment_id + '"]').remove();

                update_count();
            });
        }
        function update_count()
        {
            var number_of_comments = $('.comment-row').length;

            $('.unread .count').html(number_of_comments);
            if(number_of_comments == 0)
            {
                $('.unread').addClass('label-default').removeClass('label-warning');
                $('.admin-comments .panel-body').html('<div class="text-center">Go Enjoy Your Day! </div>');
            }
            else
            {
                $('.unread').removeClass('label-default').addClass('label-warning');
            }
        }
    </script>
@endsection
