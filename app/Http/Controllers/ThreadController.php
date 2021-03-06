<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilter;
use App\Models\Channel;
use App\Models\Thread;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Channel $channel
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel, ThreadFilter $filter)
    {
        $threads = Thread::latest()->filter($filter);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        if (request()->wantsJson()) {
            return $threads->get();
        }

        return view('threads.index')->with(['threads' => $threads->get()]);
    }

    /**
     * Display the specified resource.
     *
     * @param Channel $channel
     * @param  \App\Models\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel, Thread $thread)
    {
        return view('threads.show')->with(compact('thread'));
    }

    /**
     * A form for new thread
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('threads.create');
    }

    public function store()
    {
        $this->validate(request(), [
            'title'      => 'required',
            'body'       => 'required',
            'channel_id' => 'required|exists:channels,id',
        ]);

        $thread = Thread::create([
            'user_id'    => auth()->id(),
            'channel_id' => request('channel_id'),
            'title'      => request('title'),
            'body'       => request('body'),
        ]);

        return redirect()
            ->route('threads.show', [$thread->channel->slug, $thread->id])
            ->with('flash', 'Your thread has been published!');
    }

    public function destroy(Channel $channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect()->route('threads.index');
    }
}
