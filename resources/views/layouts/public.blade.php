<!DOCTYPE html>
<html lang="en">
<head>
    @if(env('APP_ENV') == 'production')
        <script type="text/javascript">
            (function(g,c,e,f,a){window[a]=function(){window[a].q.push(arguments)};window[a].q=[];b=c.createElement(e);d=c.getElementsByTagName(e)[0];b.async=1;b.src=f;d.parentNode.insertBefore(b,d)})(window,document,"script","//luke.switchblade.io/assets/js/blade.js","swb");
            swb('auth','$2y$10$pucKVbuL05fHO0YTjwITrOulu1WdEApRPuRcTFKUNze7FlZuzPlwW');
        </script>
    @endif
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ @isset($title) === true ? $title : '{ LukePOLO' }}</title>

    <link href='//fonts.googleapis.com/css?family=Josefin+Slab:100,400,700' rel='stylesheet' type='text/css'>

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
        @include('layouts.header')

        @if(\Request::url() == url())
            <div class="home-header" class="col-md-12 text-center">
                <p class="logo-text">
                    { Hi. I'm Luke
                </p>
                <p class="logo-sub-text">
                    a
                    <span class="words">
                        <span>web developer</span>
                        <span>boiler maker</span>
                        <span>learner</span>
                        <span>teacher</span>
                    </span>
                </p>
            </div>
        @endif
        <div class="col-md-12 text-center mini-bar"></div>
        <div class="container">
            @yield('content')
        </div>
        @include('layouts.footer')
        <!-- Scripts -->
        <script src="/js/all.js"></script>
        <script>
            $(document).ready(function()
            {
                $("img.lazy").lazyload();
                FastClick.attach(document.body);

                $('iframe[src*="youtube.com"]').wrap('<div class="youtubeWrapper" />');

                $('.owl-carousel').owlCarousel({
                    items: 1,
                    nav: false,
                    dots: true,
                    loop: true,
                    lazyLoad: true,
                    autoplay: true,
                    autoplayTimeout: 2000,
                    autoplayHoverPause: true
                });
                // Passes the XSRF-TOKEN to PHP
                $(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-XSRF-TOKEN': "{{ isset($_COOKIE['XSRF-TOKEN']) ? $_COOKIE['XSRF-TOKEN'] : '' }}"
                        }
                    });
                });
            });

            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-33266635-1', 'auto');
            ga('send', 'pageview');

        </script>
    </body>
</html>