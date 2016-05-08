<?php

namespace App\Models\Mongo;

/**
 * Class Tag
 * @package App\Models\Mongo
 */
class Tag extends \Moloquent
{
    protected $connection = 'mongodb';
    protected $guarded = ['_id'];

    /**
     * Relates a tag to a blog
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function blogs()
    {
        return $this->belongsToMany(\App\Models\Mongo\Blog::class);
    }
}