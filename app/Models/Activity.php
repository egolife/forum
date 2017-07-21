<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = ['id'];

    /**
     * Subject of this activity
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function subject()
    {
        return $this->morphTo();
    }

    public static function feed(User $user, $take = 50)
    {
        return static::where('user_id', $user->id)->latest()->with('subject')->take($take)->get()
            ->groupBy(function (Activity $activity) {
                return $activity->created_at->format('Y-m-d');
            });
    }
}
