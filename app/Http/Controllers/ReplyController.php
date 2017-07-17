<?php

namespace App\Http\Controllers;

use App\Models\Thread;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $channelSlug
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelSlug, Thread $thread)
    {
        $thread->addReply([
            'body'    => request()->body,
            'user_id' => request()->user()->id,
        ]);

        return back();
    }
}
