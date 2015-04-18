@extends('layouts.admin')

@section('content')
    <div class="col-md-10">
        <div id="summernote">Hello Summernote</div>
    </div>
    <div class="col-md-2">
        <h3>Name</h3>
        <input type="text">
        <h3>Project Image</h3>
         url / file
        <h3>Start Date</h3>
        <select>
            <input type="date">
        </select>
        <h3>End Date</h3>
        <select>
            <input type="date">
        </select>
        <h3>Related To</h3>
        <select>
            <option>Work</option>
            <option>Purdue</option>
            <option>Personal</option>
        </select>

        <h3>Technologies</h3>
        <select>
            <option>FuelPHP</option>
        </select>
    </div>
    <script type="text/javascript">
        $(document).ready(function()
        {
            $('#summernote').summernote({
                height: $(window).height() - 250
            });
        });
    </script>
@endsection
