<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            PermissionsSeeder::class,
            RolesSeeder::class,
            LearningStagesSeeder::class,
            LearningAxisSeeder::class
        ]);
    }
}
