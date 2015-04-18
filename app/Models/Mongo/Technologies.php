<?php

namespace App\Models\Mongo;

class Technologies extends \Moloquent
{
    protected $connection = 'mongodb';

    protected $guarded = ['_id'];

}