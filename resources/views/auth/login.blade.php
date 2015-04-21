@extends('layouts.admin')

@section('content')
    @if (count($errors) > 0)
        <div class="col-md-6 col-md-offset-3 alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row login-buttons">
        <div class="col-sm-12">
            Login
        </div>
        <div class="col-sm-4">
            <a href="{{ action('\App\Http\Controllers\Auth\AuthController@getService', ['google']) }}">
                <i class="fa fa-google"></i>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ action('\App\Http\Controllers\Auth\AuthController@getService', ['github']) }}">
                <i class="fa fa-github"></i>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ action('\App\Http\Controllers\Auth\AuthController@getService', ['facebook']) }}">
                <i class="fa fa-facebook"></i>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ action('\App\Http\Controllers\Auth\AuthController@getService', ['linkedin']) }}">
                <i class="fa fa-linkedin"></i>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ action('\App\Http\Controllers\Auth\AuthController@getService', ['twitter']) }}">
                <i class="fa fa-twitter"></i>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ action('\App\Http\Controllers\Auth\AuthController@getService', ['reddit']) }}">
                <i class="fa fa-reddit"></i>
            </a>
        </div>
    </div>
@endsection
