@extends('layouts.public')
@section('content')
    <div class="col-md-8 col-md-offset-2" style="margin-top:15px;">

        @foreach($blogs as $blog)
            <div class="blog">
                <h1 style="margin-bottom:-5px;">
                    { {{ $blog->name  }}
                    <small>{{ \Carbon\Carbon::now() }}</small>
                </h1>
                <div>
                    <a href="{{ action('\App\Http\Controllers\BlogController@getView', [$blog->link_name]) }}">
                        <img style="cursor:pointer;max-height: 300px;" class="center-block" src="{{ $blog->image }}">
                    </a>
                </div>
                <p>
                    {{ $blog->preview_text }}
                </p>
            </div>
        @endforeach
    </div>
@endsection


