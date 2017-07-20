<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;

class ProfileController extends Controller
{
    public function show(string $userName)
    {
        $user = User::where('name', $userName)->firstOrFail();

        $activities = $user->activity()->latest()->with('subject')->take(50)->get()
            ->groupBy(function (Activity $activity) {
                return $activity->created_at->format('Y-m-d');
            });

        return view('profiles.show')->with([
            'profile_user' => $user,
            'activities'   => $activities,
        ]);
    }
}
