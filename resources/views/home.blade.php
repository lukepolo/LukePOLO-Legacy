@extends('layouts.public')
@section('content')
    <style>
        #projects {
            height:{{ ($timelines->count() + 2 )* 100 }}px;
            width: 100%;
            opacity: 0.9;
            margin-top:-27px;
        }
    </style>
    <div class="col-lg-3">
        <svg id="projects"></svg>
    </div>
    <div class="col-lg-9">
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
                <div>
                    {!! $project->html !!}
                </div>
            </div>
        @endforeach
        </div>
    </div>
    <script>
        var small_bar = $('#small-bar');
        var projects;
        var circles = [];
        var branches = [];

        var default_x = 35;
        var default_y = 100;
        var default_r = 15;
        var big_r = 32;

        var vertical_multiplier = 1;

        var colors;
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

            draw_circle(default_x, default_y, tinycolor(colors.lines['0']).complement().toHexString());

            @foreach($timelines as $timeline)
                new_branch("{{ $timeline->name }}", "{{ $timeline->start_date }}", "{{ $timeline->end_date }}", {{ $timeline->horizontal_multiplier }});
            @endforeach

            draw();
            merge();

            // Line along side
            var start_y = default_y * vertical_multiplier;
            draw_line(default_x, start_y, start_y + default_y, colors.lines[0]);

            render_circles();

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


