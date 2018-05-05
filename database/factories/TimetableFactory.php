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
        'day_of_week' => $faker->numberBetween(1, 9999),
        'number'=> $faker->numberBetween(1, 9999),
        'is_numerator' => $faker->boolean,
        'group_id' => $group->getAttribute('id'),
        'audience_id' => $audience->getAttribute('id')
    ];
});