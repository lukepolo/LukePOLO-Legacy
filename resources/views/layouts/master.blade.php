<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{LukePOLO</title>

    <link href='http://fonts.googleapis.com/css?family=Josefin+Slab:100,400,700' rel='stylesheet' type='text/css'>

    <link href="/css/app.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/js/jquery.min.js"></script>
</head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ action('\App\Http\Controllers\WelcomeController@index') }}">LukePOLO</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="{{ action('\App\Http\Controllers\BlogController@getIndex') }}">BLOG</a>
                        </li>
                        <li>
                            <a href="#">PROJECTS</a>
                        </li>
                        <li>
                            <a href="#">RESUME</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div style="background-color: rgb(54, 134, 190)" class="col-md-12 text-center">
            <p class="logo-text">{ Hi. I'm
                Luke
            <p class="logo-sub-text">
                a
                <span class="words">
                    <span>web developer</span>
                    <span>Boiler Maker</span>
                    <span>learner</span>
                    <span>teacher</span>
                </span>
            </p>
            </p>
        </div>
        <div class="col-md-12 text-center" style="color:#FFFFFF;min-height:12px;background-color: rgb(43,116,167)">
        </div>
        @yield('content')
        <footer class="footer">
            <div class="container">
                <div class="col-md-4">

                </div>
                <div class="col-md-4">
                    <p class="text-muted">

                    </p>
                </div>
                <div class="col-md-4">

                </div>
            </div>
        </footer>
        <!-- Scripts -->
        <script src="/js/all.js"></script>
    </body>
</html>