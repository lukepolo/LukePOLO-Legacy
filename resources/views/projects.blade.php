@extends('layouts.admin')
@section('content')
    @if($projects->count() != 0)
        <table class="table table-striped">
            <thead>
            <th>Name</th>
            </thead>
            <tbody>
            @foreach($projects as $project)
                <tr>
                    <td>
                        <a href="{{ action('\App\Http\Controllers\ProjectsController@getEdit', [$project->id]) }}">
                            {{ $project->name }}
                        </a>
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
