<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    /** @test */
    public function an_authenticated_user_can_participate_in_forum_threads()
    {
        $thread = create(Thread::class);
        $reply = make(Reply::class);

        $this->signIn()
            ->post(route('replies.store', [$thread->channel->slug, $thread->id]), $reply->toArray());

        $this
            ->get(route('threads.show', [$thread->channel->slug, $thread->id]))
            ->assertSee($reply->body);
    }

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post(route('replies.store', ['channel_slug', 1]), [])
            ->assertRedirect('/login');

    }
}
