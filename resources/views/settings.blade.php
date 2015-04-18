@extends('layouts.admin')
@section('content')
	{!! Form::open(array('class' => 'col-sm-6 form-horizontal form-group-sm')) !!}
	    @foreach($settings as $setting)
            <div class="form-group">
                <?php
                switch($setting->type)
                {
                    case 'text':
                        echo Form::label($setting->id, ucwords(str_replace('_',' ', $setting->name)), array('class' => 'col-sm-2'));
                        echo Form::text($setting->id, $setting->data);
                    break;
                    case 'boolean':
                    ?>
                        <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                            <?php
                                echo Form::hidden($setting->id, "0", array('class' => 'col-sm-10'));
                                if($setting->data == 0)
                                {
                                    $setting->data = false;
                                }
                                echo Form::checkbox($setting->id, true, $setting->data);
                                echo ucwords($setting->name);
                            ?>
                            </label>
                        </div>
                        </div>
                    <?php
                    break;
                }
                ?>
            </div>
	    @endforeach
	    <div class="form-group">
            <div class="col-sm-2">
                <button type="submit" class="btn btn-info">Update</button>
            </div>
	    </div>
	{!! Form::close() !!}
@endsection
