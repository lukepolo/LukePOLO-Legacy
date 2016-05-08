@extends('layouts.admin')
@section('content')
    <h3>Tags</h3>
    @if($tags->count())
        <table class="table table-striped">
            <thead>
                <th>Name</th>
                <th>Color</th>
                <th></th>
            </thead>
            <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td><a href="{{ action('TagsController@getEdit', $tag->id) }}">{{ $tag->name }}</a></td>
                    <td>{{ $tag->color }}</td>
                    <td>
                        <a class="confirm" href="{{ action('TagsController@getDelete', $tag->id) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <a class="btn btn-info" href="{{ action('TagsController@getCreate') }}">Create</a>
@endsection
