<?php

namespace App\Models;

use App\Filters\ThreadFilter;
use App\ModelBehaviors\RecordsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = ['id'];

    protected $with = ['author', 'channel'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder) {
            $builder->withCount('replies');
        });

        static::deleting(function (Thread $thread) {
            $thread->replies->each->delete();
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
     * @return Reply|Model
     */
    public function addReply(array $attributes)
    {
        $reply = $this->replies()->create($attributes);

        $this->subscriptions
            ->where('user_id', '!=', $reply->user_id)
            ->each->notify($reply);

        return $reply;
    }

    public function scopeFilter($query, ThreadFilter $filter)
    {
        return $filter->apply($query);
    }

    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?? auth()->id()
        ]);

        return $this;
    }

    public function unsubscribe($usrId = null)
    {
        $this->subscriptions()
            ->where('user_id', $usrId ?? auth()->id())
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()->where('user_id', auth()->id())->exists();
    }
}
