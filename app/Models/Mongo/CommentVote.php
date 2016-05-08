<?php

namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\SoftDeletes;

/**
 * Class CommentVote
 * @package App\Models\Mongo
 */
class CommentVote extends \Moloquent
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'mongodb';
    protected $guarded = ['_id'];

    /**
     * Relates a comment to a vote
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}