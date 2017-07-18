<?php

namespace App\Http\Controllers;

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
     * @param Channel|null $channel
     * @return \Illuminate\Http\Response
     */
    public function index(Channel $channel = null)
    {
        if ($channel && $channel->exists) {
            $threads = $channel->threads()->latest()->get();
        } else {
            $threads = Thread::latest()->get();
        }
        return view('threads.index')->with(compact('threads'));
    }

    /**
     * Display the specified resource.
     *
     * @param string $channelSlug
     * @param  \App\Models\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channelSlug, Thread $thread)
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

        return redirect()->route('threads.show', [$thread->channel->slug, $thread->id]);
    }
}
