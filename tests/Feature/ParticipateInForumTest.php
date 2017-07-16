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
        $this->actingAs($user = factory(User::class)->create());
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->make();
        $this->post(route('threads.replies.store', $thread->id), $reply->toArray());

        $this
            ->get(route('threads.show', $thread->id))
            ->assertSee($reply->body);
    }

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->expectException(AuthenticationException::class);
        $this->post(route('threads.replies.store', 1), []);

    }
}
