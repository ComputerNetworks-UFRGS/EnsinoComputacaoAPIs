<?php

use App\Models\LearningAxis;
use App\Models\LearningStage;
use Illuminate\Database\Seeder;

class LearningAxisSeeder extends Seeder
{
    public function run()
    {
        $this->clear();
        $this->seed();
    }

    private function clear()
    {
        Schema::disableForeignKeyConstraints();

        echo "\tErasing learning_axis\n";
        DB::table('learning_axis')->truncate();

        Schema::enableForeignKeyConstraints();
    }

    private function seed()
    {
        $axis = $this->getAxis();
        foreach ($axis as $a) {
            $learningAxis = new LearningAxis();
            $learningAxis->name = $a['name'];
            $learningAxis->description = $a['description'];
            $learningAxis->learning_stages_id = LearningStage::where('code', $a['learning_stage_code'])->first()->id;
            $learningAxis->save();

            echo "\tLearning stage '$learningAxis->name' created\n";
        }
    }

    private function getAxis()
    {
        return [
            [
                'name' => 'Pensamento Computacional',
                'description' => 'Pensamento Computacional',
                'learning_stage_code' => 'EC',
                'color' => '#efffed',
                'graph_id' => 1,
                'print_order' => 2,
            ],
            [
                'name' => 'Mundo Digital',
                'description' => 'Mundo Digital',
                'learning_stage_code' => 'EC',
                'color' => '#C9DAF8',
                'graph_id' => 2,
                'print_order' => 3,
            ],
            [
                'name' => 'Cultura Digital',
                'description' => 'Cultura Digital',
                'learning_stage_code' => 'EC',
                'color' => '#f7ebe2',
                'graph_id' => 3,
                'print_order' => 1,
            ],
        ];
    }
}
