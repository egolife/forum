<?php

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class, 30)->create();
        factory(Thread::class, 10)->create(['user_id' => $users->random()->id])
            ->each(function (Thread $tread) use ($users) {
                factory(Reply::class, mt_rand(1, 10))->create([
                    'user_id'   => $users->random()->id,
                    'thread_id' => $tread->id,
                ]);
            });
    }
}
