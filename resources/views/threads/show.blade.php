@extends('layouts.app')

@section('content')
    <thread-view inline-template :initial-replies-count="{{ $thread->replies_count }}">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="level">
                            <span class="flex">
                                <a href="{{ route('profiles.show', $thread->author->name) }}">
                                    {{ $thread->author->name }}
                                </a>
                                posted:
                                {{ $thread->title }}
                            </span>

                                @can('update', $thread)
                                    <form action="{{ route('threads.destroy', [$thread->channel->slug, $thread->id]) }}"
                                          method="post"
                                    >
                                        {{ csrf_field() }}
                                        {{ method_field('delete') }}

                                        <button class="btn btn-link">Delete Thread</button>
                                    </form>
                                @endcan
                            </div>

                        </div>

                        <div class="panel-body">
                            <div class="body">{{ $thread->body }}</div>
                        </div>
                    </div>

                    <replies
                            :data="{{ $thread->replies }}"
                            @removed="repliesCount--"
                            @added="repliesCount++"
                    ></replies>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            This thread was published {{ $thread->created_at->diffForHumans() }}
                            by
                            <a href="{{ route('profiles.show', $thread->author->name) }}">{{ $thread->author->name }}</a>,
                            and currently has <span v-text="repliesCount"></span> comments.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@stop