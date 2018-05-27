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
    return [
        'name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'password' => bcrypt($faker->password), // secret
        'surname' => $faker->lastName,
        'patronymic' => $faker->firstName,
        'date_of_birth' => $faker->date(),
        'mobile_phone' => $faker->phoneNumber,
        'work_phone' => $faker->phoneNumber,
        'gender' => $faker->boolean,
    ];
});
