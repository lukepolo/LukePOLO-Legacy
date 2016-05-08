@extends('layouts.admin')

@section('content')
    {!! Form::open() !!}
        <div class="col-md-10">
            <textarea name="html" id="summernote">{{ isset($project) ? $project->html : null }}</textarea>
        </div>
        <div class="col-md-2">
                <div class="form-group">
                    {!! Form::label('Name') !!}
                    {!! Form::text('name', isset($project) ? $project->name : null) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('URL') !!}
                    {!! Form::text('URL', isset($project) ? $project->url : null) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Project Image') !!}
                    {!! Form::text('project_image', isset($project) ? $project->project_image : null) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Start Date') !!}
                    {!! Form::text('start_date', isset($project) ? $project->start_date->format('m-d-Y') : null, ['id' => 'start_date']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('End Date') !!}
                    {!! Form::text('end_date', isset($project) && !empty($project->end_date) ? $project->end_date->format('m-d-Y') : null, ['id' => 'end_date']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Timeline') !!}
                    <select name="timeline">
                        <option value="null">None</option>
                        @foreach($timelines as $timeline)
                            @if(empty($project->timeline) === false && $timeline->id == $project->timeline->id)
                                <option selected="selected" value="{{ $timeline->id }}">{{ $timeline->name }}</option>
                            @else
                                <option value="{{ $timeline->id }}">{{ $timeline->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    {!! Form::label('Technologies') !!}
                    <?php
                        if(isset($project)) {
                            $project_technologies = array_flip($project->technologies);
                        }
                    ?>
                    <select id="technologies" name="technologies[]" multiple>
                        @foreach($technologies as $technology)
                            @if(isset($project) && array_key_exists($technology->id, $project_technologies))
                                <?php
                                    unset($project_technologies[$technology->id]);
                                    $selected = 'selected="selected"';
                                ?>
                            @else
                                <?php $selected = ''; ?>
                            @endif
                            <option {{ $selected }} value="{{ $technology->id }}">
                                {{ $technology->name }}
                            </option>
                        @endforeach
                        @if(isset($project) === true)
                            @foreach($project_technologies as $technology => $key)
                                <option selected="selected" value="{{ $technology }}">
                                    {{ $technology }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            <br>
            {!! Form::submit(isset($project) ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#technologies').select2();

            $('#summernote').summernote({
                height: $(window).height() - 250
            });

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
            $('#datetimepicker1').datetimepicker();
        });
    </script>
@endpush
