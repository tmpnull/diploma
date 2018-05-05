<?php

use Faker\Generator as Faker;


$factory->define(App\Audience::class, function (Faker $faker) {
    /** @var \App\Building $building */
    $building = factory(App\Building::class, 1)->create()->first();
    return [
        'name' => $faker->jobTitle,
        'building_id' => $building->getAttribute('id'),
    ];
});