@extends('layouts.public')
@section('content')
    <div class="container blog-container">
        <div class="col-md-12 big-bottom-padding">
            <h1 class="blog-name">
                { {{ $blog->name }}
                @if(\Auth::check() && \Auth::user()->role == 'admin')
                    <a href="{{ action('BlogController@getEdit', $blog->id) }}" class="pull-right btn btn-sm btn-primary">
                        Edit
                    </a>
                @endif
            </h1>
            <small>{{ $blog->created_at->format('F jS Y g:i A') }}</small><br>
            <div class="technologies">
                @foreach($blog->tags as $tag)
                    <a href="{{ action('BlogController@getPublicIndex', ['filter' => $tag->name]) }}" class="label" style="background-color:#{{ $tag->color }}">
                        {{ $tag->name }}
                    </a>
                @endforeach
            </div>
            <hr>
            <div>
                {!! $blog->html !!}
            </div>
        </div>
    </div>
    @include('blog.comments.area')
@endsection


