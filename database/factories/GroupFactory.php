<?php

use Faker\Generator as Faker;


$factory->define(App\Group::class, function (Faker $faker) {
    /** @var \App\Speciality $speciality */
    $speciality = factory(App\Speciality::class, 1)->create()->first();
    return [
        'name' => $faker->unique()->word . $faker->randomNumber(3),
        'speciality_id' => $speciality->getAttribute('id'),
    ];
});