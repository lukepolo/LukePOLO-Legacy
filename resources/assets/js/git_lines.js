function new_branch(id, name, start_date, end_date, timeline)
{
    branches.push({
        id: id,
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
        // we want to give some space between the lines
        if(branch_index != 0)
        {
            vertical_multiplier += 2;
        }

        branch.vertical_multiplier = ++vertical_multiplier;

//                console.log(branch.name);
        $.each(branches, function()
        {
            if(branch.id != this.id)
            {
                if (
                    (
                    branch.start_date >= this.start_date &&
                    branch.start_date <= this.end_date
                    ) ||
                    (
                    branch.end_date >= this.start_date &&
                    branch.end_date <= this.end_date
                    )
                )
                {
                    // Makes sure its not a timeline
                    if (!branch.timeline_id && !branch.timeline)
                    {
//                                console.log(' HM+1 by case 1: ' + this.name);
                        branch.horizontal_multiplier++;
                    }
                    // Makes sure both have a timeline id but not an actual timeline
                    else if (branch.timeline_id && this.timeline_id && !branch.timeline)
                    {
//                                console.log(' HM+1 by case 2: ' + this.name);
                        branch.horizontal_multiplier++;
                    }
                    // Makes sure both are timelines
                    else if (branch.timeline && this.timeline)
                    {
                        if(
                            branch.start_date >= this.start_date &&
                            branch.start_date <= this.end_date
                        )
                        {
//                                    console.log(' HM+1 by case 3: ' + this.name);
                            branch.horizontal_multiplier++;
                        }
                    }
                }
            }
        });
        //console.log('HM @ '+ branch.horizontal_multiplier);
    });
}

function get_merges()
{
    // Get the proper merge levels
    $.each(branches, function(branch_index, branch)
    {
        branch_index = 0;
        $.each(branches, function()
        {
            if(branch.end_date > this.start_date)
            {

                branch.merge = this.vertical_multiplier;

                merges[branch.name] = branch.merge;
            }
        });
        //console.log(branch.name  + ' merges @ ' + branch.merge);
    });

    $.each(branches, function()
    {
        find_merge_conflicts(this);
        merge_levels.push(this.merge);
    });
}

function find_merge_conflicts(branch)
{
//            console.log('Finding conflicts with ' + branch.name);

    var conflicts = new Array();

    $.each(branches, function()
    {
        if(branch.id != this.id && branch.merge == this.merge)
        {
//                    console.log('Conflicts with ' + this.name);
            conflicts.push(this);
        }
    });

    $.each(conflicts, function()
    {
        if(branch.id != this.id)
        {
            if (branch.end_date > this.end_date)
            {
                move_up(branch);
                branch.merge+= 2;
            }
            else
            {
                move_up(this);
                this.merge = branch.merge + 2;
            }
        }
    });
}

// TODO - fix spacing
function move_up(branch)
{
//            console.log(branch.name + ' merge ++ and moving up branches : ');
    $.each(branches, function()
    {
        if(this.vertical_multiplier > branch.merge)
        {
//                    console.log('       ' + this.name);
            this.vertical_multiplier += 2;
            this.merge+=2;
        }
        else if(this.end_date > branch.end_date)
        {
            this.merge+= 2;
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

    $('#git_tree').css('height', (Math.max.apply(null, merge_levels) + 3) * default_y);
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
        draw_circle(start_x, start_y, get_analogous(colors.lines[branch.horizontal_multiplier]), branch.id);
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

function draw_circle(x, y, color, id)
{
    //start Circle
    circles.push({
        x: x,
        y: y,
        r: default_r,
        color: color,
        id : id
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
            strokeWidth: 5,
            'data-project_id': this.id
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