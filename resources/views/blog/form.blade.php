@extends('layouts.admin')
@section('content')
    {!! Form::open() !!}
    <div class="col-md-9">
        <div class="row">
            <h3>Preview Text</h3>
            {!! Form::textarea('preview_text', isset($blog) ? $blog->preview_text : null, ['class' => 'form-control', 'id' => 'preview_blog']) !!}
        </div>
        <br>
        <div class="row">
            {!! Form::textarea('html', isset($blog) ? $blog->html : null, ['class' => 'form-control', 'id' => 'blog']) !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {!! Form::label('Name') !!}
            {!! Form::text('name', isset($blog) ? $blog->name : null, ['class' => 'form-control']) !!}
        </div>
        <div class="checkbox">
            <label>
                {!! Form::hidden('draft', '0') !!}
                {!! Form::checkbox('draft', '1', isset($blog) ? $blog->draft : null, ['class' => 'checkbox']) !!}
                Draft
            </label>
        </div>
        <div class="form-group">
            {!! Form::label('Link Name') !!}
            {!! Form::text('link_name', isset($blog) ? $blog->link_name : null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('Image') !!}
            {!! Form::text('image', isset($blog) ? $blog->image : null, ['class' => 'form-control']) !!}
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


