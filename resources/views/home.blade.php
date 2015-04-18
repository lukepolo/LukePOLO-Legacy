@extends('layouts.public')
@section('content')
    <style>
        .mini-bar {
        }
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
    <style>
        .img-holder {
            height: 180px;
            overflow:hidden;
            margin-bottom: 40px;
            cursor: pointer;
        }

    </style>
    <div class="col-lg-9">
        <h1 style="margin-bottom:-5px;">{ Projects</h1>
        <small>
            <i class="fa fa-long-arrow-left"></i> You can navigate my site using my "git tree" just hover over them
            <br>
            .... or just look below
        </small>
        <hr>
        <div id="project-lists">
            <div class="col-md-6 img-holder" data-project-id="1">
                <img class="img-responsive" src="http://lukepolo.com/assets/img/portfolio/psg_robbert/Lp.png">
            </div>
            <div class="col-md-6 img-holder">
                <img class="img-responsive" src="http://lukepolo.com/assets/img/portfolio/boilerprojects.jpg">
            </div>
            <div class="col-md-6 img-holder">
                <img class="img-responsive" src="http://lukepolo.com/assets/img/portfolio/acv/acv_1.jpg">
            </div>
            <div class="col-md-6 img-holder">
                <img class="img-responsive" src="http://lukepolo.com/assets/img/portfolio/shortpolo/shortpolo_1.jpg">
            </div>
            <div class="col-md-6 img-holder">
                <img class="img-responsive" src="http://lukepolo.com/assets/img/portfolio/tipping-point.jpg">
            </div>
            <div class="col-md-6 img-holder">
                <img class="img-responsive" src="http://lukepolo.com/assets/img/portfolio/bsom.jpg">
            </div>
            <div class="col-md-6 img-holder">
                <img class="img-responsive" src="http://lukepolo.com/assets/img/portfolio/psg.jpg">
            </div>
            <div class="col-md-6 img-holder">
                <img class="img-responsive" src="http://lukepolo.com/assets/img/portfolio/trams.jpg">
            </div>
            <div class="col-md-6 img-holder">
                <img class="img-responsive" src="http://lukepolo.com/assets/img/portfolio/my-resnet.jpg">
            </div>
        </div>
        <style>
            .panel {
                border-radius: 0;;
            }
            .panel .panel-color {
                padding-top: 7px;
                background-color: #777777;
            }
            .panel-body {
                font-size: 15px;
                cursor: pointer;
            }
        </style>
        <div class="hide" id="project-view">
            <div class="row panel-links">
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <div style="background-color:#A68BBA" class="panel-color"></div>
                        <div class="panel-body">
                            FuelPHP
                            <span>
                                <a class="pull-right" target="_blank" href="http://fuelphp.com">
                                    <i style="color:#A68BBA" class="fa fa-arrow-right"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <div style="background-color:#0769AD" class="panel-color"></div>
                        <div class="panel-body">
                            Javascript/JQuery
                            <span>
                                <a class="pull-right" target="_blank" href="https://jquery.com/">
                                    <i style="color:#0769AD" class="fa fa-arrow-right"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <div class="panel-color"></div>
                        <div class="panel-body">
                            AJAX Pages
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="panel panel-default">
                        <div style="background-color:#563d7c" class="panel-color"></div>
                        <div class="panel-body">
                            Bootstrap
                            <span>
                                <a class="pull-right" target="_blank" href="http://getbootstrap.com/">
                                    <i style="color:#563d7c" class="fa fa-arrow-right"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <hr>
                    <img class="img-responsive" src="http://lukepolo.com/assets/img/portfolio/psg_robbert/Lp.png">
                    <p>
                        This was a really fun project, I was recruited to build this team running for Purdue Student
                        Government President and Vice President. Within a week I had a mock up and was ready to code!
                        I decided to build a backbone like system where they could navigate without losing focus of
                        content around them. Particiulary they wanted a video to be played and continued to play
                        if they navigated to a new page.

                        <br><br>
                        <h2>{ Problems I ran into</h2>
                        <p>
                           The ajax pages worked like a charm, but I realized there was a problem if people where
                            to share pages on facebook that directly poitned them to the correct page. There are a couple of solutions
                            but I decided to go the "backbone.js like" functionality by changing the url while they
                            continued throughout the site. I had to insert the urls into the history with javascript and that solved all the problems.
                        </p>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script>
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
            $('#project-lists').hide();
            $('#project-view').toggleClass('hide');
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


