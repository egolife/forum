<?php

namespace Tests\Feature;

use App\Models\Channel;
use Tests\TestCase;

class MenuTest extends TestCase
{
    /** @test */
    public function user_can_see_list_of_channels()
    {
        $channels = create(Channel::class, [], 2);

        $this->get(route('threads.index'))
            ->assertSee($channels[0]->name)
            ->assertSee($channels[1]->name);
    }
}
