@extends('layouts.admin')

@section('content')
    <div class="row login-buttons">
        <div class="col-sm-12">
            Login
        </div>
        <div class="col-sm-4">
            <a href="{{ action('Auth\AuthController@getService', ['google']) }}">
                <i class="fa fa-google"></i>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ action('Auth\AuthController@getService', ['github']) }}">
                <i class="fa fa-github"></i>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ action('Auth\AuthController@getService', ['facebook']) }}">
                <i class="fa fa-facebook"></i>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ action('Auth\AuthController@getService', ['linkedin']) }}">
                <i class="fa fa-linkedin"></i>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ action('Auth\AuthController@getService', ['twitter']) }}">
                <i class="fa fa-twitter"></i>
            </a>
        </div>
        <div class="col-sm-4">
            <a href="{{ action('Auth\AuthController@getService', ['reddit']) }}">
                <i class="fa fa-reddit"></i>
            </a>
        </div>
    </div>
@endsection
