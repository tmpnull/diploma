<?php

use Faker\Generator as Faker;


$factory->define(App\Timetable::class, function (Faker $faker) {
    /** @var \App\Course $course */
    $course = factory(App\Course::class, 1)->create()->first();

    /** @var \Illuminate\Support\Collection $group */
    $groups = App\Group::all();

    /** @var \Illuminate\Support\Collection $audiences */
    $audiences = App\Audience::all();

    return [
        'course_id' => $course->getAttribute('id'),
        'day_of_week' => $faker->numberBetween(1, 5),
        'number'=> $faker->numberBetween(1, 5),
        'is_numerator' => $faker->boolean,
        'is_first_semester' => $faker->boolean,
        'group_id' => $groups->random()->id,
        'audience_id' => $audiences->random()->id,
    ];
});
