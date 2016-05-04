@extends('layouts.admin')
@section('content')
    <div class="col-sm-6">
        {!! Form::open() !!}
            @foreach($settings as $setting)
                <div class="form-group">
                    <?php
                        switch($setting->type){
                            case 'text':
                                echo Form::label($setting->id, ucwords(str_replace('_',' ', $setting->name)));
                                echo Form::text($setting->id, $setting->data);
                                break;
                            case 'boolean':
                                ?>
                                    <div class="checkbox">
                                        <label>
                                        <?php
                                            echo Form::hidden($setting->id, "0");
                                            if($setting->data == 0) {
                                                $setting->data = false;
                                            }
                                            echo Form::checkbox($setting->id, true, $setting->data);
                                            echo ucwords($setting->name);
                                        ?>
                                        </label>
                                    </div>
                                <?php
                                break;
                        }
                    ?>
                </div>
            @endforeach
            {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
    </div>
@endsection
