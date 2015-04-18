@extends('layouts.public')
@section('content')
    <div class="container">
        <div class="col-md-12" style="margin-top:15px;padding-bottom: 150px;">
            <h1 style="margin-bottom:-5px;">{ {{ $blog->name }}</h1>
            <small>{{ $blog->created_at->format('F jS Y g:i A') }}</small><br>
            <div style="font-size:15px">
                @foreach($blog->tags as $tag)
                    <span style="padding: .4em .6em .3em;" class="label label-primary">
                        {{ $tag }}
                    </span>
                @endforeach
            </div>
            <hr>
            <div>
                {!! $blog->html !!}
            </div>
        </div>
    </div>
@endsection


