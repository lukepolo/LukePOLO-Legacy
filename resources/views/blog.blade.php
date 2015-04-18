@extends('layouts.public')
@section('content')
    <div class="col-md-12" style="margin-top:15px;">
        <div class="blog">
            <h1 style="margin-bottom:-5px;">{SwitchBlade</h1>
            <small>{{ \Carbon\Carbon::now() }}</small>
            <br>
            <p>
                My new blog needed a new blog ! Its about my up coming project and what I plan todo with it!
            </p>
            <div class="blog-footer">
                <a class="btn btn-info" href="{{ action('\App\Http\Controllers\BlogController@getView', [1]) }}"><i class="fa fa-arrow-right"></i></a>
            </div>
        </div>
    </div>
@endsection


