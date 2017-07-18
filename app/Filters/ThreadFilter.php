<?php

namespace App\Filters;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class ThreadFilter extends Filter
{
    protected $filters = ['by'];

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
}