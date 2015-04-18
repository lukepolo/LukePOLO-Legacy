@extends('layouts.public')
@section('content')
    <div class="col-md-8 col-md-offset-2" style="margin-top:15px;">
        @foreach($blogs as $blog)
            <div class="blog">
                <div class="row"></div>
                    <h1 style="margin-bottom:-5px;">
                        { {{ $blog->name  }}
                    </h1>
                    <div style="font-size:15px">
                        @foreach($blog->tags as $tag)
                            <span style="padding: .4em .6em .3em;" class="label label-primary">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                    <small>{{ $blog->created_at->format('F jS Y g:i A') }}</small>
                </div>
                <div class="row">
                    <a href="{{ action('\App\Http\Controllers\BlogController@getView', [$blog->link_name]) }}">
                        <img style="cursor:pointer;max-height: 300px;" class="center-block" src="{{ $blog->image }}">
                    </a>
                </div>
                <div class="row">
                    <p>
                        {{ $blog->preview_text }}
                    </p>
                </div>
                <div class="row">
                    <a class="pull-right continue-reading" href="{{ action('\App\Http\Controllers\BlogController@getView', [$blog->link_name]) }}">
                        Continue Reading ...
                    </a>
                </div>
                <hr>
            </div>

        @endforeach
    </div>
@endsection


