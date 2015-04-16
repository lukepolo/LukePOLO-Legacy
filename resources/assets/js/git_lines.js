function new_branch(name, start_date, end_date, hm)
{
    branches.push({
        name: name,
        horizontal_multiplier: hm,
        vertical_multiplier: vertical_multiplier++,
        start_date: start_date,
        end_date: end_date,
        merge: null
    });
}

function draw()
{
    console.log('Determine the branches merge levels');
    $.each(branches, function(branch_index, branch)
    {
        if(branch.end_date != null && branch_index != branches.length - 1 && branch.horizontal_multiplier != 0)
        {
            console.log(branch.name + ' merge @');

            while (branch_index < branches.length - 1)
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
        draw_circle(end_x, end_y, get_analogous(colors.lines[branch.horizontal_multiplier]));
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
    $.each(branches, function(index, branch)
    {
        // Draw a line while they do not have a merge
        while (index < branches.length - 1)
        {
            if (branch.merge >= branches[index + 1].vertical_multiplier || branch.merge == null)
            {
                var start_x = default_x * (branch.horizontal_multiplier + 1);
                var end_x = default_x + (default_x * branch.horizontal_multiplier);
                var start_y = default_y * branches[index + 1].vertical_multiplier;
                var end_y = default_y + (default_y * branches[index + 1].vertical_multiplier);
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
            var final_x = end_x - default_x * branch.horizontal_multiplier;
            var final_y = (end_y + default_y);

            if(branch.name != 'LukePOLO' || branch.name != 'Blog Post 1')
            {
                draw_curve(start_x, start_y + default_y, final_x, final_y, colors.lines[branch.horizontal_multiplier]);
            }
        }
    });
}

function get_analogous(color)
{
    if(!ag_colors[color])
    {
        ag_colors[color] = tinycolor(color).analogous(10).map(function(t)
        {
            return t.toHexString();
        });
    }
    ag_colors[color].shift();
    ag_colors[color].shift();
    return ag_colors[color].shift();
}