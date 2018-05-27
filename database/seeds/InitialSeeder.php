<?php

use Illuminate\Database\Seeder;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var \App\User $user */
        $user = new \App\User([
            'email' => 'admin@homestead.test',
            'password' => bcrypt('123456'),
            'name' => 'test',
            'surname' => 'test',
            'patronymic' => 'test',
        ]);
        $user->save();
    }
}
