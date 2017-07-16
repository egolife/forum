<?php

namespace App\Http\Controllers;

use App\Models\Thread;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Thread $thread)
    {
        $thread->addReply([
            'body'    => request()->body,
            'user_id' => request()->user()->id,
        ]);

        return back();
    }
}
