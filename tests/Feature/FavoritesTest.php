<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    /** @test */
    public function guests_can_not_favorite_anything()
    {
        $this->withExceptionHandling();
        $this->post('replies/1/favorites')->assertRedirect('/login');
    }

    /** @test */
    public function guests_can_not_see_favorite_button()
    {
        $thread = create(Thread::class);
        create(Reply::class, ['thread_id' => $thread->id]);

        $this->get(route('threads.show', [$thread->channel->slug, $thread->id]))
            ->assertDontSee('<favorite');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();
        $reply = create(Reply::class);

        $this->post(route('favorites.store', $reply->id));

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_unfavorite_a_reply()
    {
        $this->signIn();
        $reply = create(Reply::class);

        $reply->favorite(auth()->id());

        $this->delete(route('favorites.destroy', $reply->id));
        $this->assertCount(0, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();
        $reply = create(Reply::class);

        $this->post(route('favorites.store', $reply->id));
        $this->post(route('favorites.store', $reply->id));

        $this->assertCount(1, $reply->favorites);
    }
}
