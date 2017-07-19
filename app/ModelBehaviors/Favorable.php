<?php

namespace App\ModelBehaviors;


use App\Models\Favorite;

trait Favorable
{

    /**
     * Users who favorite this reply
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    /**
     * Register a new favorite for reply
     *
     * @param $userId
     */
    public function favorite($userId)
    {
        $attributes = ['user_id' => $userId];

        if (!$this->favorites()->where($attributes)->exists()) {
            $this->favorites()->create($attributes);
        }
    }

    /**
     * If this reply is favorited by current user
     *
     * @return bool
     */
    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    /**
     * Count of this reply favorites
     *
     * @return integer
     */
    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}