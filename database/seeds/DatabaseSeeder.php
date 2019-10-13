<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            LearningStagesSeeder::class,
            LearningAxisSeeder::class,
            LearningObjectsSeeder::class,
            PermissionsSeeder::class,
            RolesSeeder::class,
            TagsSeeder::class
        ]);
    }
}
