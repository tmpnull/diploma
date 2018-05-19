<?php

use Faker\Generator as Faker;


$factory->define(App\Course::class, function (Faker $faker) {
    /** @var \App\Teacher $teacher */
    $teacher = factory(App\Teacher::class, 1)->create()->first();
    return [
        'name' => $faker->unique()->word() . $faker->randomNumber(3),
        'teacher_id' => $teacher->getAttribute('id')
    ];
});