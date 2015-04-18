<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{LukePOLO</title>

    <link href='http://fonts.googleapis.com/css?family=Josefin+Slab:100,400,700' rel='stylesheet' type='text/css'>

    <link href="/css/app.css" rel="stylesheet">

    <style>
        html, body {
            font-size: 12px;
        }
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

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="/js/jquery.min.js"></script>
</head>
<body>
@include('layouts.header')
<div class="col-md-12 text-center" style="color:#FFFFFF;min-height:12px;background-color: rgb(43,116,167);margin-bottom: 15px">
</div>

<div class="container">
    @if(Auth::check())
        @include('layouts.adminmenu')
    @endif
    @yield('content')
</div>
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