<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PositionsTableSeeder::class,
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            DepartmentsTableSeeder::class,
            BuildingsTableSeeder::class,
            AudiencesTableSeeder::class,
            CoursesTableSeeder::class,
        ]);
    }
}
