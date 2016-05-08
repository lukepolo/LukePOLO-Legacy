<?php

namespace App\Models\Mongo;

/**
 * Class UserProvider
 * @package App\Models\Mongo
 */
class UserProvider extends \Moloquent
{
    protected $connection = 'mongodb';

    protected $guarded = ['_id'];

    /**
     * Relates a user provider such as google / github to a user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}