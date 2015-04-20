@extends('layouts.admin')
@section('content')
    @if($projects->count() != 0)
        <table class="table table-striped">
            <thead>
            <th>Name</th>
            <th>Timeline</th>
            <th>Created At</th>
            <th>Updated At</th>
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
                    <td></td>
                    <td>{{ $project->created_at->format('F jS Y g:i A') }}</td>
                    <td>{{ $project->updated_at->format('F jS Y g:i A') }}</td>
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
