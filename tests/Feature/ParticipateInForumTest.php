<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
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
    public function a_reply_needs_a_body()
    {
        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);

        $this->withExceptionHandling()->signIn()
            ->post(route('replies.store', [$thread->channel->slug, $thread->id]), $reply->toArray())
            ->assertSessionHasErrors('body');

    }

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post(route('replies.store', ['channel_slug', 1]), [])
            ->assertRedirect('/login');

    }

    /** @test */
    public function unauthorized_users_can_not_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create(Reply::class);
        $this->delete(route('replies.destroy', $reply->id))
            ->assertRedirect('login');

        $this->signIn()
            ->delete(route('replies.destroy', $reply->id))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_replies()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->delete(route('replies.destroy', $reply->id))
            ->assertStatus(302)
            ->assertSessionHas('flash', 'reply was deleted!');

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}
