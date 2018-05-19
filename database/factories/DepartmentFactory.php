<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Department::class, function (Faker $faker) {
    /** @var \App\Faculty $faculty */
    $faculty = factory(App\Faculty::class, 1)->create()->first();
    return [
        'name' => $faker->unique()->name . $faker->randomNumber(3),
        'abbreviation' => $faker->unique()->word . $faker->randomNumber(3),
        'number' => $faker->randomNumber(4) + time(),
        'faculty_id' => $faculty->getAttribute('id'),
    ];
});
