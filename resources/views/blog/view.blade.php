@extends('layouts.public')
@section('content')
    <div class="container blog-container">
        <div class="col-md-12 big-bottom-padding">
            <h1 class="blog-name">{ {{ $blog->name }}</h1>
            <small>{{ $blog->created_at->format('F jS Y g:i A') }}</small><br>
            <div class="technologies">
                @foreach($blog->tags as $tag)
                    <span class="label" style="background-color:#{{ $tag->color }}">
                        {{ $tag->name }}
                    </span>
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


