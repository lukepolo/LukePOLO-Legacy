@extends('layouts.public')
@section('content')
    <div class="blog-container col-md-10">
        @if(\Request::has('filter'))
            <div class="row">
                <a class="label clear-filter" href="{{ action('BlogController@getPublicIndex') }}">Clear Filters</a>
            </div>
        @endif
        @if($blogs->count())
            @foreach($blogs as $blog)
                <div class="blog">
                    <div class="row">
                        <h1 class="blog-name">
                            <a href="{{ route('blog/view', $blog->link_name) }}">{ {{ $blog->name  }}</a>
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
                        <a href="{{ route('blog/view', $blog->link_name) }}">
                            <img class="img-responsive blog-image center-block" src="{{ $blog->image }}">
                        </a>
                    </div>
                    <div class="row">
                        <p>
                            {!! $blog->preview_text !!}
                        </p>
                    </div>
                    <div class="row">
                        <a class="pull-right continue-reading" href="{{ route('blog/view', $blog->link_name) }}">
                            Continue Reading ...
                        </a>
                    </div>
                    <hr>
                </div>
            @endforeach
        @else
            <div class="row">
                <h2>Oh no, there are no blogs with that filter . . .</h2>
            </div>
        @endif
    </div>
    <div class="col-md-2">
        <div class="row text-center">
            <select id="blog-search" multiple></select>
        </div>
        <div class="row">
            <hr>
            <div class="col-sm-12 tags-area">
                @foreach($tags as $tag)
                    @if(\Request::get('filter') != $tag->name)
                        <a style="background-color:#{{ $tag->color }}" class="label pull-right" href="{{ action('BlogController@getPublicIndex', ['filter' => $tag->name]) }}">{{ $tag->name }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection


