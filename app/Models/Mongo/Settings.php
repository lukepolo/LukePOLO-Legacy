<?php

namespace App\Models\Mongo;

class Settings extends \Moloquent
{
    protected $connection = 'mongodb';

    protected $guarded = ['_id'];

}