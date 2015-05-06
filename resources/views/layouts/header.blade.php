<nav id="main-nav" class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-menu">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="{{ action('\App\Http\Controllers\HomeController@index') }}">LukePOLO</a>
        </div>
        <div id="main-menu" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <a href="{{ action('\App\Http\Controllers\BlogController@getIndex') }}">BLOG</a>
                </li>
                <li>
                    <a href="{{ action('\App\Http\Controllers\ResumeController@getIndex') }}">RESUME</a>
                </li>
                @if(Auth::check())
                    @if(Auth::user()->role == 'admin')
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            ADMIN
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ action('\App\Http\Controllers\AdminController@getIndex') }}">Dashboard</a></li>
                            <li><a href="{{ action('\App\Http\Controllers\SettingsController@getIndex') }}">Settings</a></li>
                            <li class="divider"></li>
                            <li><a href="{{ action('Auth\AuthController@getLogout') }}">Logout</a></li>
                        </ul>
                    </li>
                    @else
                    <li>
                        <li><a href="{{ action('Auth\AuthController@getLogout') }}">LOGOUT</a></li>
                    </li>
                    @endif
                @endif
            </ul>
        </div>
    </div>
</nav>