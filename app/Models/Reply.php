<?php

namespace App\Models;

use App\ModelBehaviors\Favorable;
use App\ModelBehaviors\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favorable, RecordsActivity;

    protected $guarded = [];
    protected $appends = ['favorites_count', 'is_favorited'];

    protected $with = ['author', 'favorites'];

    /**
     * An author of this reply
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Thread this reply belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function path()
    {
        return route('threads.show', [$this->thread->channel->slug, $this->thread->id]) . '#reply_' . $this->id;
    }
}
