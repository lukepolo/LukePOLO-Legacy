@extends('layouts.admin')

@section('content')
    {!! Form::open() !!}
        <div class="col-md-10">
            <textarea name="html" id="summernote">{{ isset($project) === true ? $project->html : '' }}</textarea>
        </div>
        <div class="col-md-2">

                <h3>Name</h3>
                {!! Form::text('name', isset($project) === true ? $project->name : '') !!}

                <h3>Project Image</h3>
                {!! Form::text('project_image', isset($project) === true ? $project->project_image : '') !!}

                <h3>Start Date</h3>
                {!! Form::text('start_date', isset($project) === true ? $project->start_date : '', ['id' => 'start_date']) !!}

                <h3>End Date</h3>
                {!! Form::text('end_date', isset($project) === true ? $project->end_date : '', ['id' => 'end_date']) !!}

                <h3>Related To</h3>
                <select name="related">
                    <option>Work</option>
                    <option>Purdue</option>
                    <option>Personal</option>
                </select>

                <h3>Technologies</h3>
                <?php
                    if(isset($projects))
                    {
                        $project_technologies = array_flip($project->technologies);
                    }
                ?>
                <select id="technologies" name="technologies[]" multiple>
                    @foreach($technologies as $technology)
                        @if(isset($project) === true && array_key_exists($technology->id, $project_technologies))
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
                    @foreach($project_technologies as $technology => $key)
                        <option selected="selected" value="{{ $technology }}">
                            {{ $technology }}
                        </option>
                    @endforeach
                </select>
            <br>
            {!! Form::submit(isset($project) === true ? 'Update' : 'Create') !!}
        </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        $(document).ready(function()
        {
            $('#technologies').select2({
                tags: true,
                tokenSeparators: [
                    ',',
                    ' '
                ]
            });

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
@endsection
