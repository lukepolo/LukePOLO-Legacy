<?php

namespace App\Models\Mongo;

class Blogs extends \Moloquent
{
    protected $connection = 'mongodb';

    protected $guarded = ['_id'];
}