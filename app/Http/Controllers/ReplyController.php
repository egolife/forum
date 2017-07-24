<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param string $channelSlug
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelSlug, Thread $thread)
    {
        $this->validate(request(), ['body' => 'required']);

        $thread->addReply([
            'body'    => request('body'),
            'user_id' => request()->user()->id,
        ]);

        return back()->with('flash', 'reply was added!');
    }

    /**
     * @param Reply $reply
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        return back()->with('flash', 'reply was deleted!');
    }
}
