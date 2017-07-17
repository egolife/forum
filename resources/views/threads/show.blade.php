@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="">{{ $thread->author->name }}</a> posted:
                        {{ $thread->title }}
                    </div>

                    <div class="panel-body">
                        <div class="body">{{ $thread->body }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @foreach($thread->replies as $reply)
                    @include('reply.blade.php')
                @endforeach
            </div>
        </div>

        @if(auth()->check())
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
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
                </div>
            </div>
        @else
            <p class="text-center">
                Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion
            </p>
        @endif
    </div>
@stop