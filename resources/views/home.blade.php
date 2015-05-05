@extends('layouts.public')
@section('content')
    <style>
        #projects {
            width: 100%;
            opacity: 0.9;
            margin-top:-27px;
        }
    </style>
    <div class="col-md-3">
        <svg id="projects"></svg>
    </div>
    <div class="col-md-9">
        <div class="select-title">
            <h1>Projects</h1>
            <small>
                <i class="fa fa-long-arrow-left"></i> You can navigate my site using my "git tree" just hover over them
                <br>
                .... or just look below
            </small>
            <hr>
        </div>
        @foreach($projects as $project)
            <div class="projects">
                <div class="col-md-6 img-holder" data-project_id="{{ $project->id }}">
                    <img class="img-responsive" src="{{ $project->project_image }}">
                </div>
            </div>
            <div class="project-details" id="{{ $project->id }}">
                <div class="show_projects">
                    <span class="btn btn-info">
                        <i class="fa fa-arrow-left"></i>
                    </span>
                    <h2> {{ $project->name }}</h2>
                </div>
                <hr>
                <div class="row panel-links">
                 @foreach($project->technologies as $technology)
                        <div class="col-lg-3">
                            <div class="panel panel-default">
                                <div style="background-color:#{{ isset($technologies[$technology]) ? $technologies[$technology]->color : '' }}" class="panel-color"></div>
                                <div class="panel-body">
                                    {{ isset($technologies[$technology]) ? $technologies[$technology]->name : $technology}}
                                    @if(isset($technologies[$technology]))
                                        <span>
                                            <a class="pull-right" target="_blank" href="{{ $technologies[$technology]->url }}">
                                                <i style="color:#{{ $technologies[$technology]->color }}" class="fa fa-arrow-right"></i>
                                            </a>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="project-html">
                    {!! $project->html !!}
                </div>

            </div>
        @endforeach
    </div>
    <script>
        var small_bar = $('#small-bar');
        var projects;
        var circles = [];

        var timelines = {};
        var merge_levels = new Array();
        var merges= {};

        var branches = [];

        var default_x = 35;
        var default_y = 25;
        var default_r = 14;
        var big_r = 27;

        var vertical_multiplier = 0;

        var ag_colors = {};

        var colors = {};

        $(document).on('click', '.img-holder', function()
        {
            $('.select-title, .projects').hide();
            $('#'+$(this).data('project_id')).show();

            if(small_bar.visible() == false)
            {
                $('html, body').animate({
                    scrollTop: small_bar.offset().top
                }, 200);
            }
        });

        $(document).on('click', '.show_projects', function()
        {
            $('.select-title, .projects').show();
            $('.project-details').hide()
        });

        $(document).ready(function()
        {
            projects = Snap("#projects");

            // http://paletton.com/#uid=70f0u0ke9vf4TW49xJliLoCnugw
            colors['lines'] = {};
            colors.lines['0'] = 'rgb(249, 170, 139)';
            colors.lines['1'] = 'rgb(249, 202, 139)';
            colors.lines['2'] = 'rgb(94, 131, 160)';
            colors.lines['3'] = 'rgb(95, 171, 138)';
            colors.lines['4'] = 'rgb(196, 114, 81)';
            colors.lines['5'] = 'rgb(255, 223, 179)';

            @foreach($projects->reverse() as $project)
                @if(empty($project->timeline) === false)
                    new_branch("{{ $project->id }}", "{{ $project->name }}", "{{ $project->start_date->timestamp }}", "{{ $project->end_date->timestamp }}", "{{ $project->timeline->id }}");
                    timelines["{{ $project->timeline->id }}"] = {
                        id : "{{ $project->timeline->id }}",
                        timeline_id: "{{ $project->timeline->id }}",
                        name: "{{ $project->timeline->name }}",
                        start_date: "{{ $project->timeline->start_date->timestamp }}",
                        end_date: "{{ empty($project->timeline->end_date) === false ? $project->timeline->end_date->timestamp : '' }}",
                        horizontal_multiplier: 1,
                        vertical_multiplier: 0,
                        timeline: true
                    };
                @else
                    new_branch("{{ $project->id }}", "{{ $project->name }}", "{{ $project->start_date->timestamp }}", "{{ $project->end_date->timestamp }}", "");
                @endif
            @endforeach

            get_timelines();

            draw();

            var curves = projects.paper.g(projects.paper.selectAll('.curves'));
            var lines = projects.paper.g(projects.paper.selectAll('.lines'));
            var circles = projects.paper.g(projects.paper.selectAll('circle'));
            var flip_matrix = new Snap.Matrix().scale(1, -1).translate(0, -$('#projects').height());

            curves.transform(flip_matrix);
            lines.transform(flip_matrix);
            circles.transform(flip_matrix);

            projects.paper.selectAll('circle').forEach(function(elem)
            {
                $(elem.node).attr('old_color', $(elem.node).attr('fill'));

                elem.mouseover(function()
                {
                    this.animate({
                        //fill: tinycolor($(this.node).attr('fill')).darken(10).toHexString(),
                        fill: '#FFFFFF',
                        r: big_r,
                        strokeOpacity: 1
                    },
                    200,
                    mina.easeinout);
                });

                elem.mouseout(function()
                {
                    this.animate({
                        fill: $(this.node).attr('old_color'),
                        r: default_r,
                        strokeOpacity: .3
                    },
                    200,
                    mina.easeinout);
                });
            });
        });
    </script>
@endsection


