@component('profiles.activity')
    @slot('heading')
        {{ $profile_user->name }} replied to
        <a href="{{ route('threads.show', [$activity->subject->thread->channel->slug, $activity->subject->thread->id]) }}">
            "{{ $activity->subject->thread->title }}"
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
