<div class="row panel-links">
    <div class="col-md-2">
        <div class="panel panel-default">
            <div style="background-color:rgb(249, 170, 139)" class="panel-color"></div>
            <div class="panel-body">
                Dashboard
                    <span>
                        <a class="pull-right" target="_blank" href="{{ action('\App\Http\Controllers\AdminController@getIndex') }}">
                            <i style="color:rgb(249, 170, 139)" class="fa fa-arrow-right"></i>
                        </a>
                    </span>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-default">
            <div style="background-color:rgb(249, 202, 139)" class="panel-color"></div>
            <div class="panel-body">
                Projects
                    <span>
                        <a class="pull-right" target="_blank" href="{{ action('\App\Http\Controllers\ProjectsController@getIndex') }}">
                            <i style="color:rgb(249, 202, 139)" class="fa fa-arrow-right"></i>
                        </a>
                    </span>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-default">
            <div style="background-color:rgb(94, 131, 160)" class="panel-color"></div>
            <div class="panel-body">
                Timelines
                    <span>
                        <a class="pull-right" target="_blank" href="{{ action('\App\Http\Controllers\TimelinesController@getIndex') }}">
                            <i style="color:rgb(94, 131, 160)" class="fa fa-arrow-right"></i>
                        </a>
                    </span>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-default">
            <div style="background-color:rgb(95, 171, 138)" class="panel-color"></div>
            <div class="panel-body">
                Blogs
                    <span>
                        <a class="pull-right" target="_blank" href="{{ action('\App\Http\Controllers\AdminController@getBlogs') }}">
                            <i style="color:rgb(95, 171, 138)" class="fa fa-arrow-right"></i>
                        </a>
                    </span>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-default">
            <div style="background-color:rgb(196, 114, 81)" class="panel-color"></div>
            <div class="panel-body">
                Technologies
                    <span>
                        <a class="pull-right" target="_blank" href="{{ action('\App\Http\Controllers\TechnologiesController@getIndex') }}">
                            <i style="color:rgb(196, 114, 81)" class="fa fa-arrow-right"></i>
                        </a>
                    </span>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-default">
            <div style="background-color:rgb(207, 226, 241)" class="panel-color"></div>
            <div class="panel-body">
                Not Set Yet
                    <span>
                        <a class="pull-right" target="_blank" href="{{ action('\App\Http\Controllers\AdminController@getBlogs') }}">
                            <i style="color:rgb(207, 226, 241)" class="fa fa-arrow-right"></i>
                        </a>
                    </span>
            </div>
        </div>
    </div>
</div>