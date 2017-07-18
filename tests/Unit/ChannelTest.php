<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    private $channel;

    public function setUp()
    {
        parent::setUp();
        $this->channel = create(Channel::class);
    }

    /** @test */
    public function it_consists_of_threads()
    {
        $thread = create(Thread::class, ['channel_id' => $this->channel->id]);

        $this->assertInstanceOf(Collection::class, $this->channel->threads);
        $this->assertTrue($this->channel->threads->contains($thread));
    }
}
