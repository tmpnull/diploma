<?php

use Faker\Generator as Faker;


$factory->define(App\Teacher::class, function (Faker $faker) {
    /** @var \App\User $user */
    $user = factory(App\User::class, 1)->create()->first();
    /** @var \App\Department $department */
    $department = factory(App\Department::class, 1)->create()->first();
    return [
        'user_id' => $user->getAttribute('id'),
        'department_id' => $department->getAttribute('id'),
    ];
});