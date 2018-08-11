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

$factory->define(App\User::class, function (Faker $faker) {
    /**
     * @var \Illuminate\Support\Collection $roles
     * @var \App\Role $value
     */
    $roles = App\Role::all()->filter(function ($value) {
        return $value->name === 'admin' || $value->name === 'manager';
    });

    /** @var \Illuminate\Support\Collection $degrees */
    $degrees = App\Degree::all();

    /** @var \Illuminate\Support\Collection $positions */
    $positions = App\Degree::all();

    return [
        'name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt('123456'),
        'surname' => $faker->lastName,
        'patronymic' => $faker->firstName,
        'date_of_birth' => $faker->date(),
        'mobile_phone' => $faker->phoneNumber,
        'work_phone' => $faker->phoneNumber,
        'gender' => $faker->boolean,
        'role_id' => $roles->random()->id,
        'degree_id' => $degrees->random()->id,
        'position_id' => $positions->random()->id,
    ];
});
