<?php

namespace App\Models\Mongo;

class Tag extends \Moloquent
{
    protected $connection = 'mongodb';

    protected $guarded = ['_id'];
}