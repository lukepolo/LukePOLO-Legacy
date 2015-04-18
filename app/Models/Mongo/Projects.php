<?php

namespace App\Models\Mongo;

class Projects extends \Moloquent
{
    protected $connection = 'mongodb';

    protected $guarded = ['_id'];

}