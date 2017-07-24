<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    /** @test */
    public function a_user_has_a_profile()
    {
        $user = create(User::class);

        $this->get('/profiles/' . $user->name)
            ->assertSee($user->name);
    }

    /** @test */
    public function profiles_display_all_threads_created_by_user()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->get('/profiles/' . auth()->user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function profiles_display_all_replies_written_by_user()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->get('/profiles/' . auth()->user()->name)
            ->assertSee($reply->body);
    }

    /** @test */
    public function profiles_display_all_reply_favorites_made_by_user()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);
        $reply->favorite(auth()->id());

        $this->get('/profiles/' . auth()->user()->name)
            ->assertSee(auth()->user()->name . ' favorited a reply.');
    }
}