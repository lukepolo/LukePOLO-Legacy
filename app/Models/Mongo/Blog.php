<?php

namespace App\Models\Mongo;

class Blog extends \Moloquent
{
    protected $connection = 'mongodb';

    protected $guarded = ['_id'];

    public function comments()
    {
        return $this->hasMany('\App\Models\Mongo\Comment');
    }

}