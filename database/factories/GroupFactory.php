<?php

use Faker\Generator as Faker;


$factory->define(App\Group::class, function (Faker $faker) {
    /** @var \Illuminate\Support\Collection $specialities */
    $specialities = \App\Speciality::all();

    return [
        'name' => $faker->unique()->word . $faker->randomNumber(3),
        'speciality_id' => $specialities->random()->id,
    ];
});
