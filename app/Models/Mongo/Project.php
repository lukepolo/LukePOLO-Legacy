<?php

namespace App\Models\Mongo;

/**
 * Class Project
 * @package App\Models\Mongo
 */
class Project extends \Moloquent
{
    protected $connection = 'mongodb';
    protected $guarded = ['_id'];

    protected $dates = [
        'start_date',
        'end_date'
    ];

    /**
     * Relates a project to a timeline
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timeline()
    {
        return $this->belongsTo(\App\Models\Mongo\Timeline::class);
    }

    /**
     * Relates a technologies to a project
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function technologies()
    {
        return $this->belongsToMany(\App\Models\Mongo\Technology::class);
    }
}