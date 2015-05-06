@extends('layouts.admin')
@section('content')
    @if($projects->count() != 0)
        <table class="table table-striped">
            <thead>
            <th>Name</th>
            <th>URL</th>
            <th>Timeline</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th></th>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>
                        <a href="{{ action('\App\Http\Controllers\ProjectsController@getEdit', [$project->id]) }}">
                            {{ $project->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ $project->url }}">
                            {{ $project->url }}
                        </a>
                    </td>
                    <td>{{ empty($project->timeline) === false ? $project->timeline->name : ''}}</td>
                    <td>{{ $project->start_date->format('F jS Y g:i A') }}</td>
                    <td>{{ $project->end_date->format('F jS Y g:i A') }}</td>
                    <td>
                        <a class="confirm" href="{{ action('\App\Http\Controllers\ProjectsController@getDelete', [$project->id]) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <h3>No Projects</h3>
    @endif
    <a href="{{ action('\App\Http\Controllers\ProjectsController@getCreate') }}" class="btn btn-info">Create</a>
@endsection
