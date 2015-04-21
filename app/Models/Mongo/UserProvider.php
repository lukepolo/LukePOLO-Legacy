<?php

namespace App\Models\Mongo;

class UserProvider extends \Moloquent
{
    protected $connection = 'mongodb';

    protected $guarded = ['_id'];

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
}