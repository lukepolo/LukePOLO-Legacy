@extends('layouts.public')
@section('content')
    <style>
        #projects {
            /*TODO - height variable*/
            height:{{ (50) * 50 }}px;
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
                <div class="project-html">
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

        var timelines = {};
        var merge_levels = new Array();
        var merges= {};

        var branches = [];

        var default_x = 43;
        var default_y = 50;
        var default_r = 15;
        var big_r = 32;

        var vertical_multiplier = 0;

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

            @foreach($projects->reverse() as $project)
                @if(empty($project->timeline) === false)
                    new_branch("{{ $project->name }}", "{{ $project->start_date->timestamp }}", "{{ $project->end_date->timestamp }}", "{{ $project->timeline->id }}");
                    timelines["{{ $project->timeline->id }}"] = {
                        timeline_id: "{{ $project->timeline->id }}",
                        name: "{{ $project->timeline->name }}",
                        start_date: "{{ $project->timeline->start_date->timestamp }}",
                        end_date: "{{ empty($project->timeline->end_date) === false ? $project->timeline->end_date->timestamp : '' }}",
                        horizontal_multiplier: 1,
                        vertical_multiplier: 0,
                        timeline: true
                    };
                @else
                    new_branch("{{ $project->name }}", "{{ $project->start_date->timestamp }}", "{{ $project->end_date->timestamp }}", "");
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


        function new_branch(name, start_date, end_date, timeline)
        {
            branches.push({
                name: name,
                horizontal_multiplier: 1,
                vertical_multiplier: 0,
                timeline_id : timeline,
                timeline: false,
                start_date: start_date,
                end_date: end_date,
                merge: null
            });
        }

        // Put timelines into branches
        function get_timelines()
        {
            $.each(timelines, function(timeline_name, timeline)
            {
                $.each(branches, function(branch_index, branch)
                {
                    if(branch.start_date > timeline.start_date)
                    {
                        branches.splice(branch_index, 0, timeline);
                        return false;
                    }
                });
            });
        }

        function get_hm_multipliers()
        {
            $.each(branches, function(branch_index, branch)
            {
                branch.vertical_multiplier = vertical_multiplier++;
                branch.vertical_multiplier = vertical_multiplier++;

                branch_index = 0;
//                console.log(branch.name);
                while(branch_index < branches.length)
                {
                    if(branch.name != branches[branch_index].name)
                    {
                        if (
                                (
                                    branch.start_date >= branches[branch_index].start_date &&
                                    branch.start_date <= branches[branch_index].end_date
                                ) ||
                                (
                                    branch.end_date >= branches[branch_index].start_date &&
                                    branch.end_date <= branches[branch_index].end_date
                                )
                        )
                        {


                            // Makes sure its not a timeline
                            if (!branch.timeline_id && !branch.timeline)
                            {
//                                console.log(' HM+1 by case 1: ' + branches[branch_index].name);
                                branch.horizontal_multiplier++;
                            }
                            // Makes sure both have a timeline id but not an actual timeline
                            else if (branch.timeline_id && branches[branch_index].timeline_id && !branch.timeline)
                            {
//                                console.log(' HM+1 by case 2: ' + branches[branch_index].name);
                                branch.horizontal_multiplier++;
                            }
                            // Makes sure both are timelines
                            else if (branch.timeline && branches[branch_index].timeline)
                            {
                                if(
                                    branch.start_date >= branches[branch_index].start_date &&
                                    branch.start_date <= branches[branch_index].end_date
                                )
                                {
//                                    console.log(' HM+1 by case 3: ' + branches[branch_index].name);
                                    branch.horizontal_multiplier++;
                                }
                            }
                        }
                    }
                    branch_index++;
                }
                {{--console.log('HM @ '+ branch.horizontal_multiplier);--}}
            });
        }

        function get_merges()
        {
            // Get the proper merge levels
            $.each(branches, function(branch_index, branch)
            {
                branch_index = 0;
                while(branch_index < branches.length)
                {
                    if(branch.end_date > branches[branch_index].start_date)
                    {
                        branch.merge = branches[branch_index].vertical_multiplier;
                        merges[branch.name] = branch.merge;
                    }
                    branch_index++;
                }
                {{--console.log(branch.name  + ' merges @ ' + branch.merge)--}}
            });

            $.each(branches, function()
            {
                find_merge_conflicts(this);
                merge_levels.push(this.merge);
            });

        }

        function find_merge_conflicts(branch)
        {
            console.log('Finding conflicts with ' + branch.name);

            var conflicts = new Array();

            $.each(branches, function()
            {
                if(branch.name != this.name && branch.merge == this.merge)
                {
//                    console.log('Conflicts with ' + this.name);
                    conflicts.push(this);
                }
            });

            $.each(conflicts, function()
            {
                if(branch.name != this.name)
                {
                    if (branch.end_date > this.end_date)
                    {
                        move_up(branch);
                        branch.merge++;
                    }
                    else
                    {
                        move_up(this);
                        this.merge = branch.merge + 1;
                    }
                }
            });
        }

        function move_up(branch)
        {
            console.log(branch.name + ' merge ++ and moving up branches : ');
            $.each(branches, function()
            {
                if(this.vertical_multiplier > branch.merge)
                {
//                    console.log('       ' + this.name);
                    this.vertical_multiplier++;
                    this.merge++;
                }
                else if(this.end_date > branch.end_date)
                {
                    console.log(this.name + " MOVE IT FORWARD MORE bec of "+ branch.name);
                    this.merge++;
                }
            });
        }

        function draw()
        {
            get_hm_multipliers();
            get_merges();

            var start_x;
            var final_x;

            var start_y;
            var end_y;

            // Draw most left line
            draw_line(default_x, 0, (Math.max.apply(null, merge_levels) + 3) * default_y, colors.lines[0]);

            // draw line up till they merge
            $.each(branches, function(branch_index, branch)
            {
                // also lets set the colors
                if(!colors.lines[branch.horizontal_multiplier])
                {
                    colors.lines[branch.horizontal_multiplier] = tinycolor.random().toHexString();
                }

                // If its not a timeline shift it outwards by the multiplier
                start_x = default_x + (default_x * branch.horizontal_multiplier);
                // If its not based off a timline merge it all the way back in!
                if(!branch.timeline_id || branch.timeline)
                {
                    final_x = default_x;
                }
                // Since its based off a timeline we need to adjust the final location by the timelines multiplier
                else
                {
                    // The branch can end afterwards of the timeline! so lets make sure of that
                    if(branch.end_date <= timelines[branch.timeline_id].end_date)
                    {
                        final_x = default_x + (default_x * timelines[branch.timeline_id].horizontal_multiplier);
                    }
                    else
                    {
                        final_x = default_x;
                    }
                }

                // find out where its vertical multiplier should be
                start_y = default_y + (default_y * branch.vertical_multiplier);
                end_y = default_y + (default_y * branch.merge);

                // Draw the long line up to the merge point
                draw_line(start_x, start_y, end_y, colors.lines[branch.horizontal_multiplier]);

                // Draw the Branch Curve
                draw_curve(final_x, start_y - default_y, start_x, start_y, colors.lines[branch.horizontal_multiplier]);

                // Draw Merge Curve
                draw_curve(start_x, end_y, final_x, end_y + default_y, colors.lines[branch.horizontal_multiplier]);

                // Draw the Branch Starting Circle
                draw_circle(start_x, start_y, get_analogous(colors.lines[branch.horizontal_multiplier]));
            });

            render_circles();
        }

        function draw_curve(start_x, start_y, end_x, end_y, color)
        {
            var break_point = (start_y + end_y) / 2;

            // Curved Lines to new path
            projects.path("M"+start_x+","+start_y+" C"+start_x+","+break_point+" "+end_x+","+break_point+" "+end_x+","+end_y+"").attr({
                stroke: color,
                strokeWidth: 4,
                fill: "none",
                class: 'curves'
            });
        }

        function draw_line(x, start_y, end_y, color)
        {
            projects.path("M" + x + "," + start_y + " L" + x + "," + end_y + "").attr({
                stroke: color,
                strokeWidth: 4,
                class: 'lines'
            });
        }

        function draw_circle(x, y, color)
        {
            //start Circle
            circles.push({
                x: x,
                y: y,
                r: default_r,
                color: color,
                class: 'circles'
            });
        }

        function render_circles()
        {
            var color = tinycolor.random().toHexString();

            $.each(circles, function()
            {
                projects.circle(this.x, this.y , this.r).attr({
                    fill: this.color,
                    stroke: this.color,
                    strokeOpacity: .3,
                    strokeWidth: 5
                });
            });
        }

        function get_analogous(color)
        {
            if(!ag_colors[color])
            {
                ag_colors[color] = tinycolor(color).analogous(15).map(function(t)
                {
                    return t.toHexString();
                });
            }
            ag_colors[color].shift();
            return ag_colors[color].shift();
        }
    </script>
@endsection


