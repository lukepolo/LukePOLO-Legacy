@extends('layouts.master')

@section('content')
    <link href='http://fonts.googleapis.com/css?family=Inconsolata:400,700' rel='stylesheet' type='text/css'>
    <style>
        html, body {
            font-family: Inconsolata, sans-serif;
        }
        .logo-text {
            font-size:120px;
        }

        #projects {
            width:100%;
            height:900px;
        }
    </style>
    {{--<p class="logo-text">{Luke.POLO</p>--}}

    <svg id="projects">
    </svg>
    <script>
        var projects;
        var circles = [];
        var branches = [];

        var default_x = 50;
        var default_y = 100;
        var default_r = 15;

        var vertical_multiplier = 1;

        var colors;

        var colors = {};

        $(document).ready(function()
        {


            projects = Snap("#projects");

            colors['lines'] = {};
            colors.lines['0'] = tinycolor.random().toHexString();

            draw_circle(default_x, default_y, tinycolor(colors.lines['0']).complement().toHexString());

            new_branch('Purdue', '{{ strtotime('-5 years') }}', {{ strtotime('-6 months') }});
            new_branch('LukePOLO', '{{ strtotime('-4 years') }}', {{ strtotime('-3 months')  }});
            new_branch('OnePurdue', '{{ strtotime('-3 years') }}', {{ strtotime('-2.9 years')  }});
            new_branch('BoilerProjects', {{ strtotime('-2 years') }}, {{ strtotime('-1 year') }});
            new_branch('SwitchBlade', {{ strtotime('-5 months') }});
            new_branch('Blog', {{ strtotime('today') }}, {{ strtotime('today') }});

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
                        fill: tinycolor($(this.node).attr('fill')).darken(10).toHexString()
                    },
                    200,
                    mina.easeinout);
                });

                elem.mouseout(function()
                {
                    this.animate({
                        fill: $(this.node).attr('old_color')
                    },
                    200,
                    mina.easeinout);
                });
            });

        });

        function new_branch(name, start_date, end_date)
        {
            branches.push({
                name: name,
                horizontal_multiplier: 0,
                vertical_multiplier: vertical_multiplier++,
                start_date: start_date,
                end_date: end_date,
                merge: null,
                indent: null
            });
        }

        function draw()
        {
            var groups = {};
            var group_index = 0;
            var branch_index = 0;
            var branch_index_group;
            var current_branch;

            console.log('We gotta figure out their horizontal multipliers');
            while(branch_index < branches.length - 1)
            {
                // Check to see if the branch has a greater end date than the start date
                if (branches[branch_index].end_date > branches[branch_index + 1].start_date || branches[branch_index].end_date == null)
                {
                    current_branch = branches[branch_index];
                    if(current_branch.end_date != null)
                    {
                        console.log(branches[branch_index].name+' +1 : because of ');
                    }
                    else
                    {
                        console.log(branches[branch_index].name+' +1 : because of end date is null');
                    }

                    branches[branch_index].horizontal_multiplier++;

                    // Add them to their own group!
                    groups[group_index++] = [
                            branches[branch_index]
                    ];

                    // And start a new group !
                    groups[group_index] = [];

                    branch_index_group = branch_index + 1;

                    // While the current branch has a end date that is greater than the start date we know they should be inside of that branch
                    while(
                        branch_index_group < branches[branch_index_group].length ||
                        branches[branch_index].end_date >= branches[branch_index_group].start_date
                    )
                    {
                        console.log('       '+branches[branch_index_group].name);
                        groups[group_index].push(branches[branch_index_group++]);
                        branch_index++;
                    }

                    // Go through each branch till we find something that has a end_date greater than the start date
                    $.each(groups[group_index], function(index, branch)
                    {
                        // now if that sub branch has a greater end date we have to move the whole groups multiplier
                        if(branch.end_date > branches[branch_index + 1].start_date)
                        {
                            console.log('Groups +1 ');
                            while(group_index > -1)
                            {
                                console.log('       '+group_index);
                                $.each(groups[group_index], function (index, group_branch)
                                {
                                    group_branch.horizontal_multiplier++;
                                });
                                group_index--;
                            }
                            console.log('       because of '+branch.name);
                            return;
                        }
                    });
                }
                branch_index++;
            }
            console.log('End of calculations for Horizontal Multipliers');

            console.log('Determine thier merege levels');
            $.each(branches, function(branch_index, branch)
            {
                if(branch.end_date != null && branch_index != branches.length - 1 && branch.horizontal_multiplier != 0)
                {
                    console.log(branch.name + ' merge @');
                    while (branch_index < (branches.length - 1))
                    {
                        branch_index++;
                        if (branch.end_date <= branches[branch_index].start_date)
                        {
                            console.log('        ' + branches[branch_index].name);
                            branch.merge = branches[branch_index].vertical_multiplier;
                            branch_index = branches.length;
                        }
                    }
                    if(branch.merge == null)
                    {
                        // merge at the end
                        console.log('  No merge was found, but has end date, so it merges after ' + branches[branch_index].name);
                        branch.merge = branches[branch_index].vertical_multiplier + 1;
                    }


                }

                // also lets set the colors
                if(!colors.lines[branch.horizontal_multiplier])
                {
                    colors.lines[branch.horizontal_multiplier] = tinycolor.random().toHexString();
                }

                var end_x = default_x + (default_x * branch.horizontal_multiplier);

                var start_y = default_y * branch.vertical_multiplier;
                var end_y = default_y + (default_y * branch.vertical_multiplier);

                // Draw most left line
                draw_line(default_x, start_y, end_y, colors.lines[0]);

                // Branch Line
                draw_curve(default_x, start_y, end_x, end_y, colors.lines[branch.horizontal_multiplier]);

                // Draw a circle
                draw_circle(end_x, end_y, tinycolor(colors.lines[branch.horizontal_multiplier]).complement().toHexString());
            });
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

        function merge()
        {
            var start_x;
            var end_x;
            var start_y;
            var end_y;
            var final_x;
            var final_y;

            $.each(branches, function(index, branch)
            {
                // Draw a line while they do not have a merge
                while (index < branches.length - 1)
                {
                    if (branch.merge > branches[index + 1].vertical_multiplier || branch.merge == null)
                    {
                        start_x = default_x * (branch.horizontal_multiplier + 1);
                        end_x = default_x + (default_x * branch.horizontal_multiplier);
                        start_y = default_y * branches[index + 1].vertical_multiplier;
                        end_y = default_y + (default_y * branches[index + 1].vertical_multiplier);
                        draw_line(start_x, start_y, end_y, colors.lines[branch.horizontal_multiplier]);
                    }
                    index++;
                }

                // extend 1 more if they dont have an end date!
                if(branch.end_date == null)
                {
                    start_x = default_x * (branch.horizontal_multiplier + 1);
                    start_y = default_y * (branches.length + 1);
                    end_y = default_y + (default_y * (branches.length + 1));
                    draw_line(start_x, start_y, end_y, colors.lines[branch.horizontal_multiplier]);
                }
                // finally draw a inverse curve at their merge point
                else if(branch.merge != null)
                {
                    final_x = end_x - default_x * (branch.horizontal_multiplier);
                    final_y = (end_y + default_y);

                    if(branch.name != 'LukePOLO' || branch.name != 'Blog Post 1')
                    {
                        draw_curve(start_x, start_y + default_y, final_x, final_y, colors.lines[branch.horizontal_multiplier]);
                    }

                }
            });
        }
    </script>
@endsection


