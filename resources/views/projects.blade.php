@extends('layouts.admin')
@section('content')
    @if($projects->count() != 0)
        {{ Dump($projects) }}
    @else
        <h3>No Projects</h3>
    @endif
    <a href="{{ action('\App\Http\Controllers\ProjectsController@getCreate') }}" class="btn btn-info">Create</a>
@endsection
