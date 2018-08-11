<?php

use Faker\Generator as Faker;


$factory->define(App\Audience::class, function (Faker $faker) {
    /** @var \Illuminate\Support\Collection $buildings */
    $buildings = App\Building::all();

    return [
        'name' => $faker->name,
        'building_id' => $buildings->random()->id,
    ];
});
