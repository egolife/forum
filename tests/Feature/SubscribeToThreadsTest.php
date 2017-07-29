<?php

namespace Tests\Feature;

use App\Models\Thread;
use Tests\TestCase;

class SubscribeToThreadsTest extends TestCase
{
    /** @test */
    public function a_user_can_subscribe_to_threads()
    {
        $this->signIn();
        $thread = create(Thread::class);

        $this->post(route('subscription.store', [$thread->channel->slug, $thread->id]));
        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    /** @test */
    public function a_user_can_unsubscribe_from_a_threads()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $thread->subscribe();

        $this->delete(route('subscription.destroy', [$thread->channel->slug, $thread->id]));

        $this->assertCount(0, $thread->subscriptions);
    }
}
