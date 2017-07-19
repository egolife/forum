<div class="panel panel-default">
    <div class="panel-heading">
        <a href="#">{{ $reply->author->name }}</a>
        said {{ $reply->created_at->diffForHumans() }}...
    </div>

    <div class="panel-body">
        <div class="body">{{ $reply->body }}</div>
    </div>
</div>