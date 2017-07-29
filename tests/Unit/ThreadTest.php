<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    private $thread;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }

    /** @test */
    public function it_has_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    public function it_has_author()
    {
        $this->assertInstanceOf(User::class, $this->thread->author);
    }

    /** @test */
    public function it_can_add_a_reply()
    {
        $this->thread->addReply([
            'body'    => 'Foobar',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function a_thread_belongs_to_a_channel()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf(Channel::class, $thread->channel);
    }

    /** @test */
    public function route_function_provide_correct_url()
    {
        $thread = create(Thread::class);

        $this->assertEquals(
            config('app.url') . '/threads/' . $thread->channel->slug . '/' . $thread->id,
            route('threads.show', [$thread->channel->slug, $thread->id])
        );
    }

    /** @test */
    public function a_thread_can_be_subscribed_to()
    {
        $thread = create(Thread::class);
        $thread->subscribe($userId = 1);
        $subscriptions_count = $thread->subscriptions()->where('user_id', $userId)->count();
        $this->assertEquals(1, $subscriptions_count);
    }

    /** @test */
    public function a_thread_can_be_unsubscribed_from()
    {
        $thread = create(Thread::class);
        $thread->subscribe($userId = 1);
        $thread->unsubscribe($userId);
        $this->assertCount(0, $thread->subscriptions);
    }

    /** @test */
    public function it_knows_if_auth_user_is_subscribed_to_it()
    {
        $thread = create(Thread::class);
        $this->signIn();

        $this->assertFalse($thread->isSubscribedTo);
        $thread->subscribe();
        $this->assertTrue($thread->isSubscribedTo);
    }
}
