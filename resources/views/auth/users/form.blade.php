@extends('layouts.admin')
@section('content')
    {!! Form::open() !!}
        <div class="col-md-3">
            <div class="form-group">
                {!! Form::label('First Name') !!}
                {!! Form::text('first_name', $user->first_name, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Last Name') !!}
                {!! Form::text('last_name', $user->last_name, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('Email') !!}
                {!! Form::text('email', $user->email, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::select('role', ['admin' => 'admin', 'guest' => 'guest'], $user->role, ['class' => 'form-control']) !!}
            </div>
            <br>
            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
@endsection
