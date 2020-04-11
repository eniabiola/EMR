<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Drug;
use Faker\Generator as Faker;

$factory->define(Drug::class, function (Faker $faker) {
    return [
        'name' => $faker->text(10),
        'description' => $faker->text(50),
        'code' => $faker->word(3),
    ];
});
