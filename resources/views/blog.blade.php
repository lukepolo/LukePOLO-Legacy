@extends('layouts.public')
@section('content')
    <div class="blog-container col-md-10">
        @foreach($blogs as $blog)
            <div class="blog">
                <div class="row">
                    <h1 class="blog-name">
                        { {{ $blog->name  }}
                    </h1>
                    <small>{{ $blog->created_at->format('F jS Y g:i A') }}</small>
                    <div class="technologies">
                        @foreach($blog->tags as $tag)
                            <span class="label" style="background-color:#{{ $tag->color }}">
                                {{ $tag->name }}
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
    <div class="col-md-2">
        <div class="row">
            {!! Form::text('search', null, ['placeholder' => 'Search for a blog . . .']) !!}
        </div>
        <div class="row">
            <hr>
            <div class="col-sm-12 tags-area">
                @foreach($tags as $tag)
                    <div class="label pull-right" style="background-color:#{{ $tag->color }}">
                        {{ $tag->name }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


