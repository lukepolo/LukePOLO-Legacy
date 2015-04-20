@extends('layouts.public')
@section('content')
    <div class="blog-container col-md-8 col-md-offset-2">
        @foreach($blogs as $blog)
            <div class="blog">
                <div class="row"></div>
                    <h1 class="blog-name">
                        { {{ $blog->name  }}
                    </h1>
                    <small>{{ $blog->created_at->format('F jS Y g:i A') }}</small>
                    <div class="technologies">
                        @foreach($blog->tags as $tag)
                            <span class="label label-primary">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <a href="{{ action('\App\Http\Controllers\BlogController@getView', [$blog->link_name]) }}">
                        <img class="blog-image center-block" src="{{ $blog->image }}">
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


