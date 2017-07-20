<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\TestResponse;
use Tests\TestCase;

class ManageThreadsTest extends TestCase
{
    /** @test */
    public function an_authenticated_user_can_create_new_form_threads()
    {
        $thread = make(Thread::class);

        $response = $this->signIn()->post(route('threads.store'), $thread->toArray());

        $this->get($response->headers->get('location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function guest_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get(route('threads.create'))
            ->assertRedirect('/login');

        $this->post(route('threads.store'))
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();
        $thread = create(Thread::class);
        $this->delete(route('threads.destroy', [$thread->channel->slug, $thread->id]))
            ->assertRedirect('/login');

        $this->signIn();
        $this->delete(route('threads.destroy', [$thread->channel->slug, $thread->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $this->assertDatabaseHas('threads', $thread->toArray());

        $response = $this->json('DELETE', route('threads.destroy', [$thread->channel->slug, $thread->id]));
        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /**
     * A post request to create new thread
     *
     * @param array $overwrites
     * @return TestResponse
     */
    private function publishThread(array $overwrites = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make(Thread::class, $overwrites);

        return $this->post('/threads', $thread->toArray());
    }
}
