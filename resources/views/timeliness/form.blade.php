@extends('layouts.admin')
@section('content')
    <div class="col-md-3">
        <h3>Create Timeline</h3>
        {!! \Form::open() !!}
        <div class="form-group">
            {!! Form::label('name', 'Timeline Name') !!}
            {!! Form::text('name', isset($timeline) ? $timeline->name : null ) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Start Date') !!}
            {!! Form::text('start_date', isset($timeline) ? $timeline->start_date->format('m-d-Y') : null, ['id' => 'start_date']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('End Date') !!}
            {!! Form::text('end_date', isset($timeline) && !empty($timeline->end_date) ? $timeline->end_date->format('m-d-Y') : null, ['id' => 'end_date']) !!}
        </div>
        {!! Form::submit(isset($timeline) ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#start_date').datetimepicker({
                format: "MM-DD-YYYY"
            });
            $('#end_date').datetimepicker({
                format: "MM-DD-YYYY"
            });
            $("#start_date").on("dp.change", function (e) {
                $('#end_date').data("DateTimePicker").minDate(e.date);
            });
            $("#end_date").on("dp.change", function (e) {
                $('#start_date').data("DateTimePicker").maxDate(e.date);
            });
        });
    </script>
@endpush
