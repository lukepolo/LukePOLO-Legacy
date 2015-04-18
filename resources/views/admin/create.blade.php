@extends('layouts.public')

@section('content')

    {!! Form::open() !!}
        {!! Form::select('type', ['Event' => 'event', 'Project' => 'project', 'Blog' => 'blog']) !!}
        {!! Form::text('name') !!}
        {!! Form::date('start_date') !!}
        {!! Form::date('end_date') !!}
        {!! Form::text('description', null) !!}
        {!! Form::submit('Create Project') !!}
    {!! Form::close() !!}

@endsection
