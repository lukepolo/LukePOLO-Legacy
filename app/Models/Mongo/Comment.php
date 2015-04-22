<?php

namespace App\Models\Mongo;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Comment extends \Moloquent
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $connection = 'mongodb';

    protected $guarded = ['_id'];

    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

    public function replies()
    {
        return $this->hasMany('\App\Models\Mongo\Comment', 'parent_id', '_id');
    }

    public function votes()
    {
        return $this->hasMany('\App\Models\Mongo\CommentVote');
    }

    public function blog()
    {
        return $this->belongsTo('\App\Models\Mongo\Blog');
    }

    public function delete()
    {
        $this->replies()->delete();
        $this->votes()->delete();
        return parent::delete();
    }
}