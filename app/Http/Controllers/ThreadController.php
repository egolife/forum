<?php

namespace App\Http\Controllers;

use App\Models\Thread;

class ThreadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = Thread::latest()->get();
        return view('threads.index')->with(compact('threads'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show(Thread $thread)
    {
        return view('threads.show')->with(compact('thread'));
    }

    public function store()
    {
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'title'   => request('title'),
            'body'    => request('body'),
        ]);

        return redirect()->route('threads.show', $thread->id);
    }
}
