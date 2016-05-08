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
    public function parentComment()
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
     * Gets the up votes for a comment
     * @return mixed
     */
    public function getUpVotes()
    {
        return count($this->votes->filter(function($vote) {
            return $vote->vote == 1;
        }));
    }

    /**
     * Gets the down votes for a comment
     * @return mixed
     */
    public function getDownVotes()
    {
        return count($this->votes->filter(function($vote) {
            return $vote->vote != 1;
        }));
    }

    /**
     * Gets the current users vote
     * @return mixed
     */
    public function getCurrentUserVote()
    {
        if(\Auth::check()) {
            if ($this->votes->count()) {
                $vote = $this->votes->first(function ($index, $vote) {
                    return $vote->user_id == \Auth::user()->id;
                });

                if(!empty($vote)) {
                    return $vote->vote;
                }
            }
        }
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