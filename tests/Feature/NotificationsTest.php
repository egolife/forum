<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_by_other_user()
    {
        $this->signIn();
        $thread = create(Thread::class)->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => 'some reply here',
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body'    => 'some reply here',
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {
        $this->signIn();
        $user = auth()->user();

        $thread = create(Thread::class)->subscribe();

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body'    => 'some reply here',
        ]);

        $response = $this->getJson(route('notifications.index', auth()->id()))->json();

        $this->assertCount(1, $response);
    }

    /** @test */
    public function a_user_can_mark_a_notification_as_read()
    {
        $this->signIn();
        $user = auth()->user();

        $thread = create(Thread::class)->subscribe();

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body'    => 'some reply here',
        ]);

        $this->assertCount(1, $user->unreadNotifications);

        $notification_id = $user->unreadNotifications->first()->id;

        $this->delete(route('notifications.destroy', [auth()->id(), $notification_id]));

        $this->assertCount(0, $user->fresh()->unreadNotifications);
    }
}
