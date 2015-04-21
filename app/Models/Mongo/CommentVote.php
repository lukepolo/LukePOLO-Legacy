<?php

namespace App\Models\Mongo;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class CommentVote extends \Moloquent
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $connection = 'mongodb';

    protected $guarded = ['_id'];

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }
}