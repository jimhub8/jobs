<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\models\Lead;
use Faker\Generator as Faker;

$factory->define(Lead::class, function (Faker $faker) {
    $status = [
        'open', 'closed', 'cancelled'
    ];
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 11),
        'client_name' => $faker->name,
        'client_email' => $faker->unique()->safeEmail,
        'client_phone' => $faker->phoneNumber,
        'details' => $faker->text($maxNbChars = 200),
        'status' => $status[rand(0, count($status) - 1)],
    ];
});
