<?php

use App\Models\Graph;
use App\Models\GraphEdge;
use App\Models\GraphNode;
use App\Models\LearningAxis;
use App\Models\LearningObject;
use Illuminate\Database\Seeder;

class GraphsSeeder extends Seeder
{

    private $axis = [];

    public function run()
    {
        $this->clear();
        $this->init();
        $this->seed();
    }

    private function clear()
    {
        Schema::disableForeignKeyConstraints();

        echo "\tErasing graph_edges\n";
        DB::table('graph_edges')->truncate();

        echo "\tErasing graph_nodes\n";
        DB::table('graph_nodes')->truncate();

        echo "\tErasing graphs\n";
        DB::table('graphs')->truncate();

        Schema::enableForeignKeyConstraints();
    }

    private function init()
    {
        $this->axis = [
            'PC' => LearningAxis::where('name', 'like', '%ensamento%')->first()->id,
            'MD' => LearningAxis::where('name', 'like', '%undo%')->first()->id,
            'CD' => LearningAxis::where('name', 'like', '%ultura%')->first()->id,
        ];
    }

    private function seed()
    {
        $graphs = $this->getGraphs();
        foreach ($graphs as $axis => $info) {
            $graph = new Graph();
            $graph->title = $info['title'];
            $graph->description = '';
            $graph->height = 200;
            $graph->width = 500;
            $graph->group_by_year = 1;
            $graph->save();

            echo "\tGraph '{$graph->title}' created.\n";

            $nodes = LearningObject::where('learning_axis_id', $this->axis[$axis])->get();
            $graphNodes = [];
            foreach ($nodes as $node) {
                $graphNode = new GraphNode();
                $graphNode->title = $node->name;
                $graphNode->position_x = 100;
                $graphNode->position_y = 100;
                $graphNode->graph_id = $graph->id;
                $graphNode->learning_object_id = $node->id;
                $graphNode->save();

                $graphNodes[$node->ref] = $graphNode->id;

                echo "\t\tNode '{$node->name}' created.\n";
            }

            echo "\n";

            foreach($info['edges'] as $edge) {
                $graphEdge = new GraphEdge();
                $graphEdge->graph_id = $graph->id;
                $graphEdge->node_from_id = $graphNodes[$edge[0]];
                $graphEdge->node_to_id = $graphNodes[$edge[1]];
                $graphEdge->save();

                echo "\t\tEdge '{$edge[0]}' -> '{$edge[1]}' created.\n";
            }

            echo "\n";

        }
    }

    private function getGraphs()
    {
        return [
            'PC' => [
                'title' => 'Pensamento Computacional',
                'edges' => []
            ],
            'MD' => [
                'title' => 'Mundo Digital',
                'edges' => [
                    ['01MDINFO', '01MDPROT'],
                    ['01MDINFO', '01MDCODI'],
                    ['01MDINFO', '03MDDADO'],
                    ['03MDDADO', '04MDCODI'],
                    ['01MDCODI', '04MDCODI'],
                ]
            ],
            'CD' => [
                'title' => 'Cultura Digital',
                'edges' => []
            ],
        ];
    }
}
