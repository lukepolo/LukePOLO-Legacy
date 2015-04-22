@extends('layouts.admin')

@section('content')
    // TODO  - Admin Moderation Area
    // TODO  - GIT Tree Finish UP
    // TODO  - Mobile
    <div class="col-md-6 admin-comments">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    User Comments
                    <span class="pull-right unread label @if($comments->count() == 0) label-default @else label-warning @endif">
                         {{ $comments->count() }} Messages
                    </span>
                </h3>
            </div>
            <div class="panel-body">
                @if($comments->count()  == 0)
                    <div class="text-center">
                        Go Enjoy Your Day!
                    </div>
                @else
                    @foreach($comments as $comment)
                        <span>
                            {{ $comment->comment }}<Br>
                        </span>
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
                    <div class="active-users text-center">

                    </div>
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
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function()
        {
            socket.emit('get_users');

            socket.on('users', function(users)
            {
                // Minus one because we know thats me!
                var user_count = Object.keys(users).length - 1;
                $('.active-users').html(user_count);
                if(user_count > 0)
                {
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

                    console.log(locations);
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
                    $('.active-user-locations table tbody').html('<td colspan="2" class="text-center"><h3>No users currently online!<h3></td>');
                }
            });

            $.get("{{ action('\App\Http\Controllers\AdminController@getVisits') }}", function(visits)
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
                    multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>",
                    responsive: true,
                    scaleShowVerticalLines: false
                });
            });


        })
    </script>
@endsection
