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
            AudiencesTableSeeder::class,
            BuildingsTableSeeder::class,
            CoursesTableSeeder::class,
            ConfigurationsTableSeeder::class,
            DegreesTableSeeder::class,
            DepartmentsTableSeeder::class,
            FacultiesTableSeeder::class,
            GroupsTableSeeder::class,
            PositionsTableSeeder::class,
            RolesTableSeeder::class,
            SpecialitiesTableSeeder::class,
            StudentsTableSeeder::class,
            TeachersTableSeeder::class,
            TimetablesTableSeeder::class,
            UsersTableSeeder::class,
            InitialSeeder::class,
        ]);
    }
}
