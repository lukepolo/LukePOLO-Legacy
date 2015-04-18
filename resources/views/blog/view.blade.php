@extends('layouts.public')
@section('content')
    <div class="container">
        <div class="col-md-12" style="margin-top:15px;">
            <h1 style="margin-bottom:-5px;">{SwitchBlade</h1>
            <small>{{ \Carbon\Carbon::now()->format('F jS Y g:i A') }}</small>
            <hr>
            <div>
                SwitchBlade is a new upcoming platform for A/B testing, Heat Maps, Full Length Web Screenshots, Javascript full stack errors, and more. I've been hard at work for the past year in development.
                Starting off in FuelPHP 1.7 , I finally decided that this platform needed something much larger than a static framework.
                So I finally jumped ship from Fuel and decided to go with Laravel.
                <br>
                <br>
                Here is an example of the heat mapping within SwitchBlade.
                <img class="img-responsive" src="http://shortpolo.com/NL">
                <br>
                This data is collected real time and is displayed real time as well. This allows you to view your results instantly!

                <br><br>
                I'd love to show more ....acutally I can !
                <br><br>
                KetchUrl.com is a byproduct of SwitchBlade that allows you to take full length web screenshots!
                <img class="img-responsive" src="http://shortpolo.com/vX">
                <br>
                Some use cases that I've ran into are thumbnail previews for CMS's and also verification that things look good! Whats unique about this service is that it actually runs the javascript to take the screenshot.
                <br><br>
                I'm looking forward to the upcoming months with the release of Switchblade into the Alpha and Beta stages
            </div>
        </div>
    </div>
@endsection


