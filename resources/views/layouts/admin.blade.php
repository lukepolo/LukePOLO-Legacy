<!DOCTYPE html>
<html class="admin" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ @isset($title) === true ? $title : '{ LukePOLO' }}</title>

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
<body class="admin">
@include('layouts.header')
<div class="col-md-12 text-center" class="mini-bar"></div>
<div class="container">
    @if(Auth::check())
        @include('layouts.adminmenu')
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
@include('layouts.footer')
<!-- Scripts -->
<script src="/js/admin.js"></script>
<script type="text/javascript">
    $(document).ready(function()
    {
        $(document).on("click", ".confirm", function(e)
        {
            var link = $(this);
            e.preventDefault();
            bootbox.confirm("Are you sure?", function (response)
            {
                if (response)
                {
                    window.location = link.attr('href');
                }
            });
        });

        // Render Selects with Select2
        $('select').each(function()
        {
            // we don't want our debugbar to take this effect
            if (!$(this).hasClass('phpdebugbar-datasets-switcher'))
            {
                // Make sure the select hasn't been rendered yet
                if (typeof($._data(this).hasDataAttrs) == 'undefined')
                {
                    var selected = '';

                    // Since we are going to add an option to every select
                    // we need to make sure nothing else was selected
                    if (!$(this).attr('multiple') && $(this).find('option[selected]').length == 0)
                    {
                        selected = 'selected';
                    }
                    $(this).prepend($('<option ' + selected + '></option>')).select2({placeholder: "Please select an Option"});
                }
            }
        });
    });
</script>
</body>
</html>