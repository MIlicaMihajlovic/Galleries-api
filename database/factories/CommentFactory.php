<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
        'body' => $faker->text,
        'user_id' => \App\User::inRandomOrder()->first()->id,
        'gallery_id' => \App\Gallery::inRandomOrder()->first()->id
    ];
});


          
            