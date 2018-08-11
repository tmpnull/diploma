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
            FacultiesTableSeeder::class,
            DepartmentsTableSeeder::class,
            SpecialitiesTableSeeder::class,
            GroupsTableSeeder::class,

            BuildingsTableSeeder::class,
            AudiencesTableSeeder::class,

            DegreesTableSeeder::class,
            PositionsTableSeeder::class,
            RolesTableSeeder::class,

            StudentsTableSeeder::class,
            UsersTableSeeder::class,

            TimetablesTableSeeder::class,
            ConfigurationsTableSeeder::class,
            InitialSeeder::class,
        ]);
    }
}
