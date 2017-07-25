<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index($channelSlug, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * @param string $channelSlug
     * @param Thread $thread
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($channelSlug, Thread $thread)
    {
        $this->validate(request(), ['body' => 'required']);

        $reply = $thread->addReply([
            'body'    => request('body'),
            'user_id' => request()->user()->id,
        ]);

        if (request()->wantsJson()) {
            return $reply->load('author');
        }
        return back()->with('flash', 'reply was added!');
    }

    /**
     * @param Reply $reply
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->update(request(['body']));
    }

    /**
     * @param Reply $reply
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if (request()->wantsJson()) {
            return response(['status' => 'Reply deleted'], 204);
        }

        return back()->with('flash', 'reply was deleted!');
    }
}
