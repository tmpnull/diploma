<?php

use Illuminate\Database\Seeder;

class AudiencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Audience::class, 5)->create();
    }
}
