@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <a href="">{{ $thread->author->name }}</a> posted:
                    <div class="panel-heading">{{ $thread->title }}</div>

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
    </div>
@stop