@extends('layouts.admin')
@section('content')
    @if($users->count())
        <a href="{{ action('Auth\AuthController@getUsers', ['disabled' => true]) }}">Disabled Users</a>
        <table class="table table-striped">
            <thead>
                <th>Name</th>
                <th>Role</th>
                <th>Email</th>
                <th></th>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td><a href="{{ action('Auth\AuthController@getUser', $user->id) }}">{{ $user->getName() }}</a></td>
                    <td>{{ $user->role }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if(empty($user->deleted_at))
                            <a class="confirm" href="{{ action('Auth\AuthController@getDisableLogin', $user->id) }}">Disable</a>
                        @else
                            DISABLED
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $users->render() !!}
    @else
        <h3>No Users</h3>
    @endif
@endsection
