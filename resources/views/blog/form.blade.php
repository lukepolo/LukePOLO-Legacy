@extends('layouts.admin')
@section('content')
    {!! Form::open() !!}
    <div class="col-md-10">
        <div class="row">
            <h3>Preview Text</h3>
            <textarea name="preview_text"
                      id="preview_blog">{{ isset($blog) ? $blog->preview_text : null }}</textarea>
        </div>
        <br>
        <div class="row">
            <textarea name="html" id="blog">{{ isset($blog) ? $blog->html : null }}</textarea>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {!! Form::label('Name') !!}
            {!! Form::text('name', isset($blog) ? $blog->name : null) !!}
        </div>
        <div class="checkbox">
            <label>
                {!! Form::hidden('draft', '0') !!}
                {!! Form::checkbox('draft', '1', isset($blog) ? $blog->draft : null) !!}
                Draft
            </label>
        </div>
        <div class="form-group">
            {!! Form::label('Link Name') !!}
            {!! Form::text('link_name', isset($blog) ? $blog->link_name : null) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Image') !!}
            {!! Form::text('image', isset($blog) ? $blog->image : null) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Tags') !!}
            {!! Form::select('tags[]', $tags->lists('name', 'id'), isset($blog) ? $blog->tags->lists('id')->toArray() : [], ['multiple']) !!}
        </div>
        {!! Form::submit(isset($blog) ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
    </div>

    {!! Form::close() !!}
@endsection

@push('scripts')
<script type="text/javascript">
    $(document).ready(function () {
        // save text
        $("form").each(function () {
            $(this).sisyphus({
                locationBased: true
            });
        });

        $('#tags').select2();

        $('#preview_blog').summernote({
            height: 150
        });

        $('#blog').summernote({
            height: $(window).height() - 150
        });

        $(document).on('keyup', '.note-editable', function () {
            var textarea = $(this).parent().prev('textarea');
            textarea.val($(this).html());
            textarea.trigger('change');
        });
    });
</script>
@endpush


