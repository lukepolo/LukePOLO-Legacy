@extends('layouts.master')

@section('content')
    <link href='http://fonts.googleapis.com/css?family=Inconsolata:400,700' rel='stylesheet' type='text/css'>
    <style>
        html, body {
            font-family: Inconsolata;
        }
        .logo-text {
            font-size:120px;
        }

        #projects {
            width:100%;
            height:800px;
        }
    </style>
    <p class="logo-text">{Luke.POLO</p>

    <svg id="projects">
    </svg>
    <script>
        var projects;
        var circles = new Array();
        var branches = new Array()  ;

        var default_x = 50;
        var default_y = 100;
        var default_r = 15;

        var vertical_multiplier = 1;

        $(document).ready(function()
        {
            projects = Snap("#projects");

            draw_circle(default_x, default_y)
            draw_line(default_x, default_y, default_y + default_y);

            new_branch('Purdue', '{{ strtotime('-5 years') }}', {{ strtotime('-6 months') }});
            new_branch('LukePOLO', '{{ strtotime('-4 years') }}', {{ strtotime('-3 months   ')  }});
            new_branch('BoilerProjects', {{ strtotime('-2 years') }}, {{ strtotime('-1 year') }});
            new_branch('SwitchBlade', {{ strtotime('-5 months') }});
            new_branch('Blog Post 1', {{ strtotime('-4 months') }}, {{ strtotime('-4 months') }});
            new_branch('Blog Post 2', {{ strtotime('-3.9 months') }}, {{ strtotime('-3.9 months') }});

            draw();

            // Merge Lines
            merge();

            var start_y = default_y * vertical_multiplier;
            draw_line(default_x, start_y, start_y + default_y);

            render_circles();

            var lines = projects.paper.g(projects.paper.selectAll('path'));
            var circles = projects.paper.g(projects.paper.selectAll('circle'));

            var flip_matrix = new Snap.Matrix().scale(1, -1).translate(0, -$('#projects').height());

            lines.transform(flip_matrix);
            circles.transform(flip_matrix);

            projects.paper.selectAll('circle').forEach(function(elem)
            {
                $(elem.node).attr('old_color', $(elem.node).attr('fill'));

                elem.mouseover(function()
                {
                    this.animate({
                        fill: tinycolor($(this.node).attr('fill')).darken(10).toString()
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
            var horizontal_multiplier = 1;

            var groups = {};
            var group_index = 0;
            var branch_index = 0;

            console.log('We gotta figure out their horizontal multipliers');
            while(branch_index < branches.length - 1)
            {
                // Check to see if the branch has a greater end date than the start date
                if (branches[branch_index].end_date > branches[branch_index + 1].start_date || branches[branch_index].end_date == null)
                {
                    var current_branch = branches[branch_index];
                    console.log(branches[branch_index].name+' + 1 : because of ');
                    branches[branch_index].horizontal_multiplier++;

                    // Add them to their own group!
                    groups[group_index++] = new Array(
                            branches[branch_index]
                    );

                    // And start a new group !
                    groups[group_index] = new Array();

                    var branch_index_group = branch_index + 1;

                    // While the current branch has a end date thats greater than the start date we know they should be inside of that branch
                    while(
                        branch_index_group < branches[branch_index_group].length ||
                        branches[branch_index].end_date >= branches[branch_index_group].start_date
                    )
                    {
                        console.log('       '+branches[branch_index_group].name);
                        groups[group_index].push(branches[branch_index_group++]);
                        branch_index++;
                        current_branch.merge = branches[branch_index_group].vertical_multiplier;

                    }
                    console.log('MERGE POINT @ '+ branches[branch_index_group].name);


                    // Go through each branch till we find somthing that has a end_date greater than the start date
                    $.each(groups[group_index], function(index, branch)
                    {
                        // now if that sub branch has a greater end date we have to move the whole groups multiplier
                        if(branch.end_date > branches[branch_index + 1].start_date)
                        {
                            console.log('Groups');
                            while(group_index > -1)
                            {
                                console.log('       '+group_index);
                                $.each(groups[group_index], function (index, branch)
                                {
                                    branch.horizontal_multiplier++;
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

            $.each(branches, function(index, branch)
            {
                var end_x = default_x + (default_x * branch.horizontal_multiplier);

                var start_y = default_y * branch.vertical_multiplier;
                var end_y = default_y + (default_y * branch.vertical_multiplier);

                // Draw most left line
                draw_line(default_x, start_y, end_y);

                // Branch Line
                draw_curve(default_x, start_y, end_x, end_y);

                // Draw a circle
                draw_circle(end_x, end_y);
            });
        }

        function draw_curve(start_x, start_y, end_x, end_y )
        {
            var break_point = (start_y + end_y) / 2;

            // Curved Lines to new path
            projects.path("M"+start_x+","+start_y+" C"+start_x+","+break_point+" "+end_x+","+break_point+" "+end_x+","+end_y+"").attr({
                stroke: "rgb(0, 153, 153)",
                strokeWidth: 3,
                fill: "none"
            });
        }

        function draw_line(x, start_y, end_y, circle)
        {
            if(circle)
            {
                draw_circle(x, start_y);
            }

            projects.path("M" + x + "," + start_y + " L" + x + "," + end_y + "").attr({
                stroke: "rgb(0, 153, 153)",
                strokeWidth: 3
            });

        }

        function draw_circle(x, y)
        {
            //start Circle
            circles.push({
                x: x,
                y: y,
                r: default_r
            });
        }

        function render_circles()
        {
            $.each(circles, function()
            {
                var rand_color = tinycolor.random().toString();
                projects.circle(this.x, this.y , this.r).attr({
                    fill: rand_color,
                    stroke: rand_color,
                    strokeOpacity: .3,
                    strokeWidth: 5
                });
            });
        }

        function merge()
        {
            $.each(branches, function(index, branch)
            {
                while (index < branches.length - 1)
                {
                    if (branch.merge > branches[index + 1].vertical_multiplier || branch.merge == null)
                    {
                        var start_x = default_x * (branch.horizontal_multiplier + 1);
                        var end_x = default_x + (default_x * branch.horizontal_multiplier);
                        var start_y = default_y * branches[index + 1].vertical_multiplier;
                        var end_y = default_y + (default_y * branches[index + 1].vertical_multiplier);
                        draw_line(start_x, start_y, end_y);
                    }
                    index++;
                }

                // extend 1 more
                if(branch.end_date == null)
                {
                    console.log(branch);
                    console.log(branch.vertical_multiplier);

                    var start_x = default_x * (branch.horizontal_multiplier + 1);
                    var start_y = default_y * (branches.length + 1);
                    var end_y = default_y + (default_y * (branches.length + 1));
                    draw_line(start_x, start_y, end_y);
                }
                else if(start_x)
                {
                    console.log(branch.name+' merge @ '+branch.horizontal_multiplier);

                    // finally draw a inverse curve
                    var final_x = end_x - default_x * (branch.horizontal_multiplier);
                    var final_y = (end_y + default_y);

                    draw_curve(start_x, start_y + default_y, final_x, final_y);
                }


            });
        }
    </script>
@endsection


