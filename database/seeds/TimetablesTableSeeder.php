<?php

use Illuminate\Database\Seeder;

class TimetablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Timetable::class, 5)->create();
    }
}
