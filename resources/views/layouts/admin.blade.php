<!DOCTYPE html>
<html class="admin" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ @isset($title) === true ? $title : '{ LukePOLO' }}</title>

    <link href='//fonts.googleapis.com/css?family=Josefin+Slab:100,400,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="{{ elixir('css/app.css') }}">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
    <body class="admin">
        @include('layouts.core.header')
        <div class="col-md-12 text-center" class="mini-bar"></div>
        <div class="container">
            @if(Auth::check())
                @include('layouts.core.adminmenu')
            @endif
            @if (Session::has('success'))
                <div class="col-md-6 col-md-offset-3  alert alert-success">
                    <strong>Success!</strong><br><br>
                    <ul>
                        {{ Session::get('success') }}
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>
        @include('layouts.core.footer')
        <!-- Scripts -->
        <script src="{{ elixir('js/admin.js') }}"></script>
        <script type="text/javascript">
            // Passes the XSRF-TOKEN to PHP
            $(function() {
                $.ajaxSetup({
                    headers: {
                        'X-XSRF-TOKEN': "{{ isset($_COOKIE['XSRF-TOKEN']) ? $_COOKIE['XSRF-TOKEN'] : '' }}"
                    }
                });
            });
        </script>
        @stack('scripts')
    </body>
</html>