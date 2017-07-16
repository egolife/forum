<?php

namespace Tests\Unit;

use App\Models\Reply;
use App\Models\User;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    /** @test */
    public function it_has_an_author()
    {
        $reply = factory(Reply::class)->create();

        $this->assertInstanceOf(User::class, $reply->author);
    }
}
