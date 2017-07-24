<reply inline-template :attributes="{{ $reply }}" v-cloak>
    <div id="reply_{{ $reply->id }}" class="panel panel-default">
        <div class="panel-heading">
            <div class="level">
                <h5 class="flex">
                    <a href="{{ route('profiles.show', $reply->author->name) }}">{{ $reply->author->name }}</a>
                    said {{ $reply->created_at->diffForHumans() }}...
                </h5>

                @if(auth()->check())
                    <favorite :reply="{{ $reply }}"></favorite>
                @endif
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
                <button class="btn btn-danger btn-xs" @click="destroy">Delete</button>
            </div>
        @endcan
    </div>
</reply>
