<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\models\Stage;
use Faker\Generator as Faker;

$factory->define(Stage::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 10),
        'firm_id' => $faker->numberBetween($min = 1, $max = 10),
        'stage' => $faker->city,
    ];
});
