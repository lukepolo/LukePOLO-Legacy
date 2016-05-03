@extends('layouts.public')
@section('content')
    <div class="col-md-3 visible-md visible-lg">
        <svg id="git_tree"></svg>
    </div>
    <div class="col-md-9">
        <div class="select-title">
            <h1>Projects</h1>
            <div>
                <small>
                    <span class="visible-md visible-lg">
                        <i class="fa fa-long-arrow-left"></i> You can navigate my site using my "git tree" just click / hover over them
                    </span>
                    <span class="visible-sm visible-xs">
                       Click on the images to find out more
                </small>
            </div>
            <hr>
        </div>

        @foreach($projects as $project)
            <div class="project">
                <div class="col-md-6 img-holder" data-project_id="{{ $project->id }}">

                    @if(!File::exists($modifiedIMG = public_path('img/cache/').$project->project_image))
                        <?php
                            $pathInfo = pathinfo($project->project_image);
                            if(isset($pathInfo['dirname']) && !File::exists($newDir = public_path('img/cache/').$pathInfo['dirname'])) {
                                File::makeDirectory($newDir);
                            }

                            GlideImage::create(base_path('resources/assets/img/screenshots').'/'.$project->project_image)->modify(['w' => 390])->save(public_path('img/cache/').$project->project_image);
                        ?>
                    @endif
                    <img class="img-responsive" src="{{ asset('img/cache/'.$project->project_image) }}">
                </div>
            </div>
            <div class="project-details" id="{{ $project->id }}">
                <div class="show_projects">
                    <span class="btn btn-info">
                        <i class="fa fa-arrow-left"></i>
                    </span>
                    <h2> {{ $project->name }} <small><a target="_blank" href="{{ $project->url }}">{{ $project->url }}</a></small></h2>
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
    @if(!Agent::isMobile())
        <script type="text/javascript">
            var projects;

            // INIT Arrays
            var circles = [];
            var merge_levels = [];
            var branches = [];

            // INIT Objects
            var timelines = {};
            var merges= {};
            var ag_colors = {};
            var colors = {};

            // Set default Variables
            var default_x = 35;
            var default_y = 25;
            var default_r = 14;
            var big_r = 27;
            var vertical_multiplier = 0;

            $(document).ready(function()
            {
                projects = Snap("#git_tree");

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
                var flip_matrix = new Snap.Matrix().scale(1, -1).translate(0, -$('#git_tree').height());

                curves.transform(flip_matrix);
                lines.transform(flip_matrix);
                circles.transform(flip_matrix);

                projects.paper.selectAll('circle').forEach(function(elem)
                {
                    $(elem.node).attr('old_color', $(elem.node).attr('fill'));

                    elem.mouseover(function()
                    {
                        this.animate({
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
    @endif
@endsection


