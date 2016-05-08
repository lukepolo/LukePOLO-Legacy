@extends('layouts.admin')
@section('content')
    <h3>Timelines</h3>
    @if($timeliness->count())
        <table class="table table-striped">
            <thead>
            <th>Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th></th>
            </thead>
            <tbody>
            @foreach($timeliness as $timeline)
                <tr>
                    <td>
                        <a href="{{ action('TimelinessController@getEdit', $timeline->id) }}">{{ $timeline->name }}</a>
                    </td>
                    <td>{{ $timeline->start_date->format('F jS Y g:i A') }}</td>
                    <td>{{ !empty($timeline->end_date) ? $timeline->end_date->format('F jS Y g:i A') : '' }}</td>
                    <td>
                        <a class="confirm" href="{{ action('TimelinessController@getDelete', $timeline->id) }}">Delete</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    <a class="btn btn-info" href="{{ action('TimelinessController@getCreate') }}">Create</a>
@endsection
