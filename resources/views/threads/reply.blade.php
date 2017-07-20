<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <h5 class="flex">
                <a href="{{ route('profiles.show', $reply->author->name) }}">{{ $reply->author->name }}</a>
                said {{ $reply->created_at->diffForHumans() }}...
            </h5>

            <div class="">
                <form action="{{ route('favorites.store', $reply->id) }}" method="POST">
                    {{ csrf_field() }}
                    <button class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count }}
                        {{ str_plural('Favorite', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="body">{{ $reply->body }}</div>
    </div>
</div>