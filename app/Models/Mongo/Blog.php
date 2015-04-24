<?php

namespace App\Models\Mongo;

class Blog extends \Moloquent
{
    protected $connection = 'mongodb';

    protected $guarded = ['_id'];

    public function comments()
    {
        return $this->hasMany('\App\Models\Mongo\Comment')->orderBy('created_at', 'desc');
    }

    public function tags()
    {
        return $this->belongsToMany('\App\Models\Mongo\Tag');
    }
}