<?php

use Faker\Generator as Faker;


$factory->define(App\Student::class, function (Faker $faker) {
    /** @var \App\User $user */
    $user = factory(App\User::class, 1)->create()->first();
    /** @var \App\Group $group */
    $group = factory(App\Group::class, 1)->create()->first();
    return [
        'user_id' => $user->getAttribute('id'),
        'group_id' => $group->getAttribute('id'),
    ];
});