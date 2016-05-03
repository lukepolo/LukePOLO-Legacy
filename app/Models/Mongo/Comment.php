<?php

namespace App\Models\Mongo;

use Jenssegers\Mongodb\Eloquent\SoftDeletes;

/**
 * Class Comment
 * @package App\Models\Mongo
 */
class Comment extends \Moloquent
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $connection = 'mongodb';
    protected $guarded = ['_id'];

    /**
     * Relates to the blog
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function blog()
    {
        return $this->belongsTo('\App\Models\Mongo\Blog');
    }

    /**
     * Relates to other parent comments
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comment()
    {
        return $this->belongsTo('\App\Models\Mongo\Comment', 'parent_id', '_id');
    }

    /**
     * Relates the replies to a comment
     * @return mixed
     */
    public function replies()
    {
        return $this->hasMany('\App\Models\Mongo\Comment', 'parent_id', '_id')->orderBy('created_at', 'asc');
    }
    /**
     * Relates a comment to a user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('\App\Models\User');
    }

    /**
     * Relates votes to the comment
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany('\App\Models\Mongo\CommentVote');
    }

    /**
     * On delete we want to cascade deletes
     * @return bool|null
     * @throws \Exception
     */
    public function delete()
    {
        $this->replies()->delete();
        $this->votes()->delete();
        return parent::delete();
    }
}