<?php

namespace App\Models\Mongo;

/**
 * Class Blog
 * @package App\Models\Mongo
 */
class Blog extends \Moloquent
{
    protected $connection = 'mongodb';
    protected $guarded = ['_id'];

    /**
     * Relates the comments to a blog
     * @return mixed
     */
    public function comments()
    {
        return $this->hasMany(\App\Models\Mongo\Comment::class)->orderBy('created_at', 'desc');
    }

    /**
     * Relates tags that ar set on the blog
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(\App\Models\Mongo\Tag::class);
    }
}