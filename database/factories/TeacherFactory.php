<?php

use Faker\Generator as Faker;


$factory->define(App\Teacher::class, function (Faker $faker) {
    /** @var \App\User $user */
    $user = factory(App\User::class, 1)->create()->first();
    $user->role()->associate(\App\Role::where('name', 'teacher')->first())->save();

    /** @var \Illuminate\Support\Collection $departments */
    $departments = App\Department::all();

    return [
        'user_id' => $user->getAttribute('id'),
        'department_id' => $departments->random()->id,
    ];
});
