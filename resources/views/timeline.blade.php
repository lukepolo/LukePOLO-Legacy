@extends('layouts.admin')
@section('content')
    <h3>Timelines</h3>
    @if($timelines->count() != 0)
        <table class="table table-striped">
            <thead>
            <th>Name</th>
            <th>URL</th>
            <th>Color</th>
            <th></th>
            </thead>
            <tbody>
            @foreach($timelines as $timeline)
                <tr>
                    <td><a href="{{ action('\App\Http\Controllers\TimelinesController@getEdit', [$timeline->id]) }}">{{ $timeline->name }}</a></td>
                    <td>{{ $timeline->color }}</td>
                    <td>
                        <a class="confirm" href="{{ action('\App\Http\Controllers\TimelinesController@getDelete', [$timeline->id]) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <a class="btn btn-info" href="{{ action('\App\Http\Controllers\TimelinesController@getCreate') }}">Create</a>
@endsection
