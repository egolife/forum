@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{ route('profiles.show', $thread->author->name) }}">{{ $thread->author->name }}</a>
                        posted:
                        {{ $thread->title }}
                    </div>

                    <div class="panel-body">
                        <div class="body">{{ $thread->body }}</div>
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                {{ $replies->links() }}

                @if(auth()->check())
                    <form action="{{ route('replies.store', [$thread->channel->slug, $thread->id]) }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea name="body" id="body" rows="4" class="form-control"
                                      placeholder="Have smth to say?"
                            ></textarea>
                        </div>
                        <button type="submit" class="btn btn-default">Post</button>
                    </form>
                @else
                    <p class="text-center">
                        Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion
                    </p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }}
                        by <a href="{{ route('profiles.show', $thread->author->name) }}">{{ $thread->author->name }}</a>,
                        and currently has {{ trans_choice('main.comments', $thread->replies_count) }}.
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop