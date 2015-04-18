@extends('layouts.admin')
@section('content')
    <h3>Create Technology</h3>
    {!! \Form::open() !!}
        {!! Form::label('name', 'Technology Name') !!}
        {!! Form::text('name', isset($technology) ? $technology->name : '' ) !!}
        {!! Form::label('url', 'URL') !!}
        {!! Form::text('url', isset($technology) ? $technology->url : '') !!}
        {!! Form::label('color', 'Color') !!}
        {!! Form::text('color', isset($technology) ? $technology->color : '') !!}
        {!! Form::submit(isset($technology) ? 'Update' : 'Create') !!}
    {!! Form::close() !!}
@endsection
