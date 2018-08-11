<?php

use Faker\Generator as Faker;


$factory->define(App\Student::class, function (Faker $faker) {
    /** @var \App\User $user */
    $user = factory(App\User::class, 1)->create()->first();
    $user->role()->associate(\App\Role::where('name', 'student')->first())->save();

    /** @var \Illuminate\Support\Collection $groups */
    $groups = App\Group::all();

    return [
        'user_id' => $user->getAttribute('id'),
        'group_id' => $groups->random()->getAttribute('id'),
    ];
});
