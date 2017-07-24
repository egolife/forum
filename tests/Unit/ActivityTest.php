<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use Carbon\Carbon;
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

    /** @test */
    public function it_records_activity_when_a_reply_is_favorited()
    {
        $this->signIn();

        $reply = create(Reply::class);
        $this->assertDatabaseMissing('activities', ['type' => 'created_favorite']);
        $reply->favorite(auth()->id());

        $this->assertCount(3, Activity::all());
        $this->assertDatabaseHas('activities', ['type' => 'created_favorite']);
    }

    /** @test */
    public function it_fetches_activity_feed_for_any_user()
    {
        $this->signIn();

        create(Thread::class, ['user_id' => auth()->id(), 'created_at' => Carbon::now()]);

        create(Thread::class, ['user_id' => auth()->id(), 'created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed(auth()->user(), 50);
        $this->assertTrue($feed->keys()->contains(Carbon::now()->format('Y-m-d')));
        $this->assertTrue($feed->keys()->contains(Carbon::now()->subWeek()->format('Y-m-d')));
    }

    /** @test */
    public function it_removes_activity_when_reply_unfavorited()
    {
        $this->signIn();

        $reply = create(Reply::class);
        $reply->favorite(auth()->id());
        $this->assertDatabaseHas('activities', ['type' => 'created_favorite']);
        $reply->unfavorite();
        $this->assertDatabaseMissing('activities', ['type' => 'created_favorite']);
    }
}
