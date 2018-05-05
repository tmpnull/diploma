<?php

use Faker\Generator as Faker;


$factory->define(App\Group::class, function (Faker $faker) {
    /** @var \App\Department $department */
    $department = factory(App\Department::class, 1)->create()->first();
    return [
        'name' => $faker->word,
        'department_id' => $department->getAttribute('id'),
    ];
});