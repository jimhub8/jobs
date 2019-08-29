<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Jobtype;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Jobtype::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 11),
        'title' => $faker->jobTitle,
        'code' => Str::random(10),
        'description' => $faker->text($maxNbChars = 200),
        'amount' => $faker->numberBetween($min = 1000, $max = 8000),
    ];
});
