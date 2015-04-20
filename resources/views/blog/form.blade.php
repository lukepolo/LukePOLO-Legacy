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
                <label style="font-size:15px;">
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
                <select id="tags" multiple name="tags[]">
                    @if(isset($blog) === true)
                        @foreach($blog->tags as $tag)
                            <option selected="selected" value="{{ $tag }}"}>
                                {{ $tag }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
            {!! Form::submit(isset($blog) === true ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
    <script type="text/javascript">
        $(document).ready(function()
        {
            $('#tags').select2({
               tags: true
            });

            $('#preview_blog').summernote({
                height: 150
            });


            $('#blog').summernote({
                height: $(window).height() - 150
            });
        });
    </script>
@endsection


