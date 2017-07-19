<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ThreadFilter extends Filter
{
    protected $filters = ['by', 'popular'];

    /**
     * Filter query by a given username
     *
     * @param $username
     * @return Builder
     */
    protected function by($username): Builder
    {
        $user = User::where('name', $username)->firstOrFail();

        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter query according to most popular threads
     *
     * @return Builder
     */
    protected function popular(): Builder
    {
        $this->builder->getQuery()->orders = [];
        return $this->builder->orderBy('replies_count', 'desc');
    }
}