@extends('layouts.admin')
@section('content')
    @if($blogs->count() != 0)
        <table class="table table-striped">
            <thead>
                <th>Name</th>
                <th>Draft</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Preview</th>
                <th></th>
            </thead>
            <tbody>
            @foreach($blogs as $blog)
                <tr>
                    <td>
                        <a href="{{ action('BlogController@getEdit', [$blog->id]) }}">
                            {{ $blog->name }}
                        </a>
                    </td>
                    <td>
                        @if($blog->draft == 1)
                            Yes
                        @else
                            No
                        @endif
                    </td>
                    <td>
                        {{ $blog->created_at }}
                    </td>
                    <td>
                        {{ $blog->updated_at }}
                    </td>
                    <td>
                        <a href="{{ action('BlogController@getView', [$blog->link_name]) }}">
                            {{ $blog->link_name }}
                        </a>
                    </td>
                    <td>
                        <a class="confirm" href="{{ action('BlogController@getDelete', [$blog->id]) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <h3>No Blogs</h3>
    @endif
    <a href="{{ action('BlogController@getCreate') }}" class="btn btn-info">Create</a>
@endsection
