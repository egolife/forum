<reply inline-template :attributes="{{ $reply }}" v-cloak>
    <div id="reply_{{ $reply->id }}" class="panel panel-default">
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
            <div v-if="editing">
                <div class="form-group">
                    <textarea name="" id="" cols="30" rows="5" class="form-control" v-model="body"></textarea>
                </div>

                <button class="btn btn-xs btn-primary" @click="update">Update</button>
                <button class="btn btn-xs btn-link" @click="editing = false ">Cancel</button>
            </div>
            <div v-else>
                <div class="body" v-text="body"></div>
            </div>
        </div>

        @can('update', $reply)
            <div class="panel-footer level">
                <button class="btn btn-xs mr-1" @click="editing = true">Edit</button>
                <form action="{{ route('replies.destroy', $reply->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('delete') }}

                    <button class="btn btn-danger btn-xs">Delete</button>
                </form>
            </div>
        @endcan
    </div>
</reply>
