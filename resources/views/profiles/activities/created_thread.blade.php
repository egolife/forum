@component('profiles.activity')
    @slot('heading')
        {{ $profile_user->name }} published a
        <a href="{{ route('threads.show', [$activity->subject->channel->slug, $activity->subject->id]) }}">
            {{ $activity->subject->title }}
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
