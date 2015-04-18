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

            <h3>Name</h3>
            {!! Form::text('name', isset($blog) === true ? $blog->name : '') !!}

            <h3>Link Name</h3>
            {!! Form::text('link_name', isset($blog) === true ? $blog->link_name : '') !!}



            <h3>Image</h3>
            {!! Form::text('image', isset($blog) === true ? $blog->image : '') !!}

            <h3>Tags</h3>
            <select id="tags" multiple name="categories[]">
                @foreach($blog->categories as $category)
                    <option selected="selected" value="{{ $category }}"}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>

            {!! Form::submit(isset($blog) === true ? 'Update' : 'Create') !!}
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


