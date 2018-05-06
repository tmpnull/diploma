<?php

use Faker\Generator as Faker;


$factory->define(App\Course::class, function (Faker $faker) {
    /** @var \App\Teacher $teacher */
    $teacher = factory(App\Teacher::class, 1)->create()->first();
    return [
        'name' => $faker->word,
        'teacher_id' => $teacher->getAttribute('id')
    ];
});