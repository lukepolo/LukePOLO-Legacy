@extends('layouts.admin')
@section('content')
    {!! Form::open() !!}
        <div class="col-md-10">
            <div class="row">
                <h3>Preview Text</h3>
                <textarea name="preview_text" id="preview_blog">{{ isset($blog) === true ? $blog->preview_text : '' }}</textarea>
            </div>
            <br>
            <div class="row">
                <textarea name="html" id="blog">{{ isset($blog) === true ? $blog->html : '' }}</textarea>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                {!! Form::label('Name') !!}
                {!! Form::text('name', isset($blog) === true ? $blog->name : '') !!}
            </div>
            <div class="checkbox">
                <label>
                    {!! Form::hidden('draft', '0') !!}
                    {!! Form::checkbox('draft', '1', isset($blog) === true ? $blog->draft : '') !!}
                    Draft
                </label>
            </div>
            <div class="form-group">
                {!! Form::label('Link Name') !!}
                {!! Form::text('link_name', isset($blog) === true ? $blog->link_name : '') !!}
            </div>
            <div class="form-group">
                {!! Form::label('Image') !!}
                {!! Form::text('image', isset($blog) === true ? $blog->image : '') !!}
            </div>
            <div class="form-group">
                {!! Form::label('Tags') !!}
                @if(isset($blog) === true)
                    <?php $blog_tags = $blog->tags->keyBy('_id')->toArray(); ?>
                @endif

                <select id="tags" multiple name="tags[]">
                    @foreach($tags as $tag)
                        @if(isset($blog_tags) === true && array_key_exists($tag->id, $blog_tags) === true)
                            <option selected="selected" value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @else
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            {!! Form::submit(isset($blog) === true ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
        </div>

    {!! Form::close() !!}
    <script type="text/javascript">
        $(document).ready(function()
        {
            // save text
            $("form").each(function()
            {
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

            $(document).on('keyup', '.note-editable', function()
            {
                var textarea = $(this).parent().prev('textarea');
                textarea.val($(this).html());
                textarea.trigger('change');
            });

        });
    </script>
@endsection


