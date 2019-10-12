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
            $graph->group_by_year = 0;
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

            foreach ($info['edges'] as $edge) {
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
                'edges' => [
                    ['01PCALGO', '03PCDEFI'],
                    ['01PCALGO', '02PCALGO'],
                    ['03PCDEFI', '06PCTECN'],
                    ['03PCDEFI', '06PCINTR'],
                    ['02PCIDEN', '03PCALGO'],
                    ['02PCIDEN', '06PCINTR'],
                    ['03PCINTR', '03PCALGO'],
                    ['02PCALGO', '03PCALGO'],
                    ['03PCALGO', '04PCALGO'],
                    ['06PCTECN', '04PCALGO'],
                    // ['06PCTECN', '06PCTECN'],
                    ['01PCORGA', '02PCMODE'],
                    ['02PCMODE', '04PCESTR'],
                    ['04PCESTR', '04PCALGO'],
                    ['04PCESTR', '05PCESTR'],
                    // ['05PCESTR', '05PCESTR'],
                    ['05PCESTR', '06PCTIPO'],
                    ['04PCALGO', '05PCESTR'],
                    ['06PCTIPO', '06PCLING'],
                    ['06PCTIPO', '07PCAUTO'],
                    ['06PCTIPO', '07PCESTR'],
                    ['07PCESTR', '08PCPROG'],
                    ['08PCPROG', '09PCESTR'],
                    ['09PCESTR', '09PCPROG'],
                    // ['08PCPROG', '08PCPROG'],
                    ['05PCESTR', '08PCPROG'],
                    ['08PCPROG', '09PCPROG'],
                    ['04PCALGO', '06PCLING'],
                    ['06PCTECN', '06PCLING'],
                    ['06PCTECN', '07PCTECN'],
                    ['06PCTECN', '08PCPARA'],
                    ['07PCTECN', '08PCTECN'],
                    ['07PCTECN', '07PCPROG'],
                    ['08PCTECN', '09PCTECN'],
                    ['08PCTECN', '08PCPROG'],
                    ['09PCTECN', '09PCPROG'],
                    ['06PCINTR', '07PCAUTO'],
                    ['06PCINTR', '06PCLING'],
                    ['06PCLING', '07PCPROG'],
                    // ['07PCPROG', '07PCPROG'],
                    ['07PCPROG', '08PCPROG'],
                    ['07PCAUTO', '07PCPROG'],
                    ['07PCESTR', '07PCPROG'],
                ]

            ],
            'MD' => [
                'title' => 'Mundo Digital',
                'edges' => [
                    ['01MDINFO', '01MDPROT'],
                    ['01MDINFO', '01MDCODI'],
                    ['01MDINFO', '03MDDADO'],
                    ['03MDDADO', '04MDCODI'],
                    ['01MDCODI', '04MDCODI'],
                    ['01MDPROT', '06MDPROT'],
                    ['04MDCODI', '06MDPROT'],
                    ['04MDCODI', '07MDINTE'],
                    ['04MDCODI', '06MDFUND'],
                    ['06MDPROT', '07MDINTE'],
                    ['06MDPROT', '07MDARMA'],
                    ['01MDMAQU', '03MDDADO'],
                    ['01MDMAQU', '04MDCODI'],
                    ['01MDMAQU', '03MDINTE'],
                    ['01MDMAQU', '02MDHARD'],
                    ['01MDMAQU', '02MDNOCA'],
                    ['03MDINTE', '05MDARQU'],
                    ['03MDINTE', '06MDFUND'],
                    ['02MDHARD', '05MDARQU'],
                    ['02MDHARD', '05MDSIST'],
                    ['02MDNOCA', '05MDSIST'],
                    ['06MDFUND', '07MDINTE'],
                    ['06MDFUND', '07MDARMA'],
                    ['06MDFUND', '08MDFUND'],
                    ['05MDARQU', '07MDARMA'],
                    ['05MDSIST', '08MDFUND'],
                    ['07MDARMA', '08MDFUND'],
                    ['07MDINTE', '09MDSEGU'],
                    ['08MDFUND', '09MDSEGU'],
                ]
            ],
            'CD' => [
                'title' => 'Cultura Digital',
                'edges' => []
            ],
        ];
    }
}
