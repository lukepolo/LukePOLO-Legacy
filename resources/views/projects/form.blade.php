@extends('layouts.admin')

@section('content')
    {!! Form::open(['enctype' => 'multipart/form-data']) !!}
        <div class="col-md-9">
            <textarea name="html" id="summernote">{{ isset($project) ? $project->html : null }}</textarea>
        </div>
        <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('Name') !!}
                    {!! Form::text('name', isset($project) ? $project->name : null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('URL') !!}
                    {!! Form::text('URL', isset($project) ? $project->url : null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Project Image') !!}
                    <div class="dropzone">
                        <div class="@if(!isset($project)) hide @endif js-preview-reset btn btn-xs btn-primary">Reset</div>
                        <h4 class="@if(isset($project)) hide @endif  dropzone-text">Drop files here or click to upload.</h4>
                        <input type="file" name="project_image" id="js-image-upload" accept="image/jpeg">
                        <img id="image-preview" class="img-responsive" src="{{ isset($project) ? asset('img/uploads/project_images/'.$project->project_image) : null }}"/>
                    </div>

                </div>
                <div class="form-group">
                    {!! Form::label('Start Date') !!}
                    {!! Form::text('start_date', isset($project) ? $project->start_date->format('m-d-Y') : null, ['class' => 'form-control', 'id' => 'start_date']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('End Date') !!}
                    {!! Form::text('end_date', isset($project) && !empty($project->end_date) ? $project->end_date->format('m-d-Y') : null, ['class' => 'form-control', 'id' => 'end_date']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Timeline') !!}
                    {!! Form::select('timeline', $timelines->lists('name', 'id'), isset($project) ? $project->timeline_id : [], ['class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    {!! Form::label('Technologies') !!}
                    {!! Form::select('technologies[]', $technologies->lists('name', 'id'), isset($project) ? $project->technologies->lists('id')->toArray() : [], ['class' => 'form-control', 'multiple']) !!}
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

            $("#js-image-upload").on('click', function() {
                clearPreview();
            });

            $("#js-image-upload").on('change' ,function() {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#image-preview').attr('src', e.target.result);
                    $('.js-preview-reset').removeClass('hide');
                    $('.dropzone-text').addClass('hide');
                };

                reader.readAsDataURL(this.files[0]);
            });

            $('.js-preview-reset').on('click', function() {
                clearPreview();
            });

            function clearPreview() {
                $('#js-image-upload').val('');
                $('#image-preview').attr('src', '');
                $('.js-preview-reset').addClass('hide');
                $('.dropzone-text').removeClass('hide');
            }
        });
    </script>
@endpush
