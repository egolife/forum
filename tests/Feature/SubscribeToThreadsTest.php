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

        $this->assertCount(1, $thread->subscriptions);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => 'some reply here',
        ]);

//        auth()->user()->notifications;
    }
}
