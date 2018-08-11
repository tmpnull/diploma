<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigurationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configurations')->insert([
            [
                'key' => 'start_of_first_semester',
                'value' => '2018-09-01',
            ],
            [
                'key' => 'start_of_second_semester',
                'value' => '2019-01-14',
            ],
        ]);
    }
}
