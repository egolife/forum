<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    /** @test */
    public function it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->assertDatabaseHas('activities', [
            'type'         => 'created_thread',
            'user_id'      => auth()->id(),
            'subject_id'   => $thread->id,
            'subject_type' => get_class($thread),
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        create(Reply::class);

        $this->assertCount(2, Activity::all());
    }
}
