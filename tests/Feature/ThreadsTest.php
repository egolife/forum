<?php

namespace Tests\Feature;

use App\Models\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_user_can_browse_threads()
    {
        $thread = factory(Thread::class)->create();
        $response = $this->get('/threads');

        $response
            ->assertStatus(200)
            ->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_visit_thread_page()
    {
        $thread = factory(Thread::class)->create();
        $response = $this->get('/threads/' . $thread->id);

        $response->assertSee($thread->title);
    }
}
