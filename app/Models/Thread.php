<?php

namespace App\Models;

use App\Filters\ThreadFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    protected $guarded = ['id'];

    protected $with = ['author', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });
    }

    /**
     * Replies for this thread
     *
     * @return HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * Author of this thread
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Channel this thread belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Create new reply in this thread with provided attributes
     *
     * @param array $attributes
     */
    public function addReply(array $attributes)
    {
        $this->replies()->create($attributes);
    }

    public function scopeFilter($query, ThreadFilter $filter)
    {
        return $filter->apply($query);
    }
}
