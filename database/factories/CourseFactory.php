<?php

use Faker\Generator as Faker;


$factory->define(App\Course::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
    ];
});