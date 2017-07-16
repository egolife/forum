<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Thread extends Model
{
    protected $guarded = ['id'];

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
     * Create new reply in this thread with provided attributes
     *
     * @param array $attributes
     */
    public function addReply(array $attributes)
    {
        $this->replies()->create($attributes);
    }
}
