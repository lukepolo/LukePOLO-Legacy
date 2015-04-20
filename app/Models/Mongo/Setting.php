<?php

namespace App\Models\Mongo;

class Setting extends \Moloquent
{
    protected $connection = 'mongodb';

    protected $guarded = ['_id'];

}