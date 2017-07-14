<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;

$factory->define(User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Thread::class, function (Faker\Generator $faker) {
    return [
        'title'   => $faker->sentence,
        'body'    => $faker->paragraph,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
    ];
});

$factory->define(Reply::class, function (Faker\Generator $faker) {
    return [
        'body'    => $faker->paragraph,
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'thread_id' => function () {
            return factory(Thread::class)->create()->id;
        },
    ];
});
