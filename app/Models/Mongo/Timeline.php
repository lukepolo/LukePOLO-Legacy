<?php

namespace App\Models\Mongo;

class Timeline extends \Moloquent
{
    protected $connection = 'mongodb';

    protected $guarded = ['_id'];

}