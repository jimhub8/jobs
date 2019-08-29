<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\models\Cases;
use Faker\Generator as Faker;

$factory->define(Cases::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 10),
        'client_id' => $faker->numberBetween($min = 1, $max = 10),
        'firm_id' => $faker->numberBetween($min = 1, $max = 10),
        'case' => $faker->word(),
        'case_no' => $faker->numberBetween($min = 1, $max = 800),
        'case_stage' => $faker->numberBetween($min = 1, $max = 10),
        'firm_member' => $faker->name,
        'practice_area' => $faker->numberBetween($min = 1, $max = 10),
        'leading_attoney' => $faker->numberBetween($min = 1, $max = 10),
        'status' => $faker->numberBetween($min = 1, $max = 10),
    ];
});

