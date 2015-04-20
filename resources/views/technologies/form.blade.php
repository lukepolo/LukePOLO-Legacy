@extends('layouts.admin')
@section('content')
    <div class="col-md-3">
        <h3>Create Technology</h3>
        {!! \Form::open() !!}
            <div class="form-group">
                {!! Form::label('name', 'Technology Name') !!}
                {!! Form::text('name', isset($technology) ? $technology->name : '' ) !!}
            </div>
            <div class="form-group">
                {!! Form::label('url', 'URL') !!}
                {!! Form::text('url', isset($technology) ? $technology->url : '') !!}
            </div>
            <div class="form-group">
                {!! Form::label('color', 'Color') !!}
                {!! Form::text('color', isset($technology) ? $technology->color : '') !!}
            </div>
            {!! Form::submit(isset($technology) ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@endsection
