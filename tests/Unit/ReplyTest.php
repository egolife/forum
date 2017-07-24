<?php

namespace Tests\Unit;

use App\Models\Favorite;
use App\Models\Reply;
use App\Models\User;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    /** @test */
    public function it_has_an_author()
    {
        $reply = create(Reply::class);

        $this->assertInstanceOf(User::class, $reply->author);
    }

    /** @test */
    public function reply_favorites_removed_when_reply_deleted()
    {
        $user = create(User::class);
        $reply = create(Reply::class);

        $reply->favorite($user->id);
        $reply->delete();

        $this->assertEquals(0, Favorite::count());
    }
}
