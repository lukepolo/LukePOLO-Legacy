<div class="row panel-links">
    <div class="col-md-2">
        <div class="panel panel-default">
            <div class="panel-color"></div>
            <div class="panel-body">
                Dashboard
                <span>
                    <a class="pull-right" href="{{ action('\App\Http\Controllers\AdminController@getIndex') }}">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-default">
            <div class="panel-color"></div>
            <div class="panel-body">
                Projects
                <span>
                    <a class="pull-right" href="{{ action('\App\Http\Controllers\ProjectsController@getIndex') }}">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-default">
            <div class="panel-color"></div>
            <div class="panel-body">
                Blogs
                <span>
                    <a class="pull-right" href="{{ action('\App\Http\Controllers\AdminController@getBlogs') }}">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-default">
            <div class="panel-color"></div>
            <div class="panel-body">
                Timelines
                <span>
                    <a class="pull-right" href="{{ action('\App\Http\Controllers\TimelinesController@getIndex') }}">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-default">
            <div class="panel-color"></div>
            <div class="panel-body">
                Technologies
                <span>
                    <a class="pull-right" href="{{ action('\App\Http\Controllers\TechnologiesController@getIndex') }}">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel panel-default">
            <div class="panel-color"></div>
            <div class="panel-body">
                Tags
                <span>
                    <a class="pull-right" href="{{ action('\App\Http\Controllers\TagsController@getIndex') }}">
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>
</div>
@if($errors->has())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <ul>
                <li>
                    {{ $error }}
                </li>
            </ul>
        @endforeach
    </div>
@endif