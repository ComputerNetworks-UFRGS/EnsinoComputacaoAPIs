<?php

use App\Models\LearningStage;
use Illuminate\Database\Seeder;

class LearningStagesSeeder extends Seeder
{
    public function run()
    {
        $this->clear();
        $this->seed();
    }

    private function clear()
    {
        Schema::disableForeignKeyConstraints();

        echo "\tErasing learning_stages\n";
        DB::table('learning_stages')->truncate();

        Schema::enableForeignKeyConstraints();
    }

    private function seed()
    {
        $stages = $this->getStages();
        foreach ($stages as $a) {
            $learningStage = new LearningStage();
            $learningStage->code = $a['code'];
            $learningStage->name = $a['name'];
            $learningStage->save();

            echo "\tLearning stage '$learningStage->code' created\n";
        }
    }

    private function getStages()
    {
        return [
            [
                'code' => 'EI',
                'name' => 'Ensino Inicial',
            ],
            [
                'code' => 'EF',
                'name' => 'Ensino Fundamental',
            ],
            [
                'code' => 'EM',
                'name' => 'Ensino Médio',
            ],
            [
                'code' => 'EC',
                'name' => 'Ensino Computacional',
            ],
        ];
    }
}
