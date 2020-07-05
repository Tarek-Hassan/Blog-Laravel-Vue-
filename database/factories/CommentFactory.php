<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        //
        'body' => $faker->paragraph,
        'user_id' => $faker->numberBetween(1,4),
        'commentable_type'=>'App\Post',
        'commentable_id'=>$faker->numberBetween(1,20),
    ];
});
