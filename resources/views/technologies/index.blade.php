@extends('layouts.admin')
@section('content')
    <h3>Technologies</h3>
    @if($technologies->count())
        <table class="table table-striped">
            <thead>
                <th>Name</th>
                <th>URL</th>
                <th>Color</th>
                <th></th>
            </thead>
            <tbody>
                @foreach($technologies as $technology)
                    <tr>
                        <td><a href="{{ action('TechnologiesController@getEdit', $technology->id) }}">{{ $technology->name }}</a></td>
                        <td>{{ $technology->url }}</td>
                        <td>{{ $technology->color }}</td>
                        <td>
                            <a class="confirm" href="{{ action('TechnologiesController@getDelete', $technology->id) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    <a class="btn btn-info" href="{{ action('TechnologiesController@getCreate') }}">Create</a>
@endsection
