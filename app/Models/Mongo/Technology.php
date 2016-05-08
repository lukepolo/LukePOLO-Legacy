<?php

namespace App\Models\Mongo;

/**
 * Class Technology
 * @package App\Models\Mongo
 */
class Technology extends \Moloquent
{
    protected $connection = 'mongodb';
    protected $guarded = ['_id'];

    /**
     * Relates a tag to a blog
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(\App\Models\Mongo\Project::class);
    }
}