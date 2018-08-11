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

$factory->define(App\Speciality::class, function (Faker $faker) {
    /** @var \Illuminate\Support\Collection $departments */
    $departments = \App\Department::all();

    return [
        'name' => $faker->unique()->word . $faker->randomNumber(3),
        'number' => $faker->unique()->randomNumber(4) + $faker->unique()->randomNumber(4),
        'department_id' => $departments->random()->id,
    ];
});
