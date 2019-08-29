<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\models\Client;
use Illuminate\Support\Str;
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

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'counsel' => $faker->name,
        'nextof_kin' => $faker->name,
        'case_nature' => $faker->word,
        'email' => $faker->unique()->safeEmail,
        'user_id' => $faker->numberBetween($min = 1, $max = 10),
        'client_id' => $faker->numberBetween($min = 1, $max = 10),
        'firm_id' => $faker->numberBetween($min = 1, $max = 10),
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
    ];
});
