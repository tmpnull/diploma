<?php

use Faker\Generator as Faker;


$factory->define(App\Timetable::class, function (Faker $faker) {
    /** @var \App\Course $course */
    $course = factory(App\Course::class, 1)->create()->first();
    /** @var \App\Group $group */
    $group = factory(App\Group::class, 1)->create()->first();
    /** @var \App\Audience $audience */
    $audience = factory(App\Audience::class, 1)->create()->first();
    return [
        'course_id' => $course->getAttribute('id'),
        'day_of_week' => $faker->randomNumber(4),
        'number'=> $faker->randomNumber(4),
        'is_numerator' => $faker->boolean,
        'is_first_semester' => $faker->boolean,
        'group_id' => $group->getAttribute('id'),
        'audience_id' => $audience->getAttribute('id')
    ];
});