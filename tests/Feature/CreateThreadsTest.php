<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    /** @test */
    public function an_authenticated_user_can_create_new_form_threads()
    {
        $thread = make(Thread::class);

        $this->signIn()->post(route('threads.store'), $thread->toArray());

        $this->get(route('threads.show', 1))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function guest_may_not_create_threads()
    {
        $this->expectException(AuthenticationException::class);
        $this->post(route('threads.store'), []);

    }
}
