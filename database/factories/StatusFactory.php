<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\models\Status;
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

$factory->define(Status::class, function (Faker $faker) {
    return [
        'firm_id' => $faker->numberBetween($min = 1, $max = 10),
        'description' => $faker->realText(),
        'user_id' => $faker->numberBetween($min = 1, $max = 10),
        'status' => $faker->city,
    ];
});
