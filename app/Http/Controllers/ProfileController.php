<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    public function show(string $userName)
    {
        $user = User::where('name', $userName)->firstOrFail();

        return view('profiles.show')->with([
            'profile_user' => $user,
            'threads'      => $user->threads()->paginate(),
        ]);
    }
}
