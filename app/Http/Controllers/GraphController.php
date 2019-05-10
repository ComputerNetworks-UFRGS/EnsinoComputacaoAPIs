<?php

namespace App\Http\Controllers;

use App\Models\Graph;
use App\Models\GraphEdge;
use App\Models\Topic;

class GraphController extends Controller
{

    public function list()
    {
        return Graph::get();
    }

    public function detail($id)
    {
        $graph = Graph::with([
            'nodes',
            'edges'
        ])->find($id);

        return $this->formatForDiagramVue($graph);
    }

    public function update(Request $request, $id)
    {
        $graphRequest = $request->graph;

        $graph = Graph::with([
            'nodes',
            'edges'
        ])->find($id);

        $graph->width = @$graphRequest->width;
        $graph->height = @$graphRequest->height;
        $graph->background = @$graphRequest->background;

        // $nodes = $request->nodes ?: [];
        // $edges = $request->edges ?: [];

    }

    private function formatForDiagramVue($graph)
    {
        $nodes = [];
        foreach($graph->nodes as $node) {
            $nodes[] = [
                'id' => $node->id,
                'content' => [
                    'text' => $node->title,
                    'type' => $node->type,
                    'topic_id' => $node->topic_id,
                ],
                'width' => $node->width,
                'height' => $node->height,
                'shape' => $node->shape,
                'point' => [
                    'x' => (float) $node->position_x,
                    'y' => (float) $node->position_y,
                ],
            ];
        }

        $links = [];
        foreach($graph->edges as $edge) {
            $links[] = [
                'id' => "{$edge->graph_id}-{$edge->node_from_id}-{$edge->node_to_id}" ,
                'source' => $edge->node_from_id,
                'destination' => $edge->node_to_id,
                'point' => [
                    'x' => (float) $node->position_x,
                    'y' => (float) $node->position_y,
                ],
                'color' => $edge->color,
            ];
        }

        return [
            'width' => $graph->width,
            'height' => $graph->height,
            'background' => $graph->background,
            'nodes' => $nodes,
            'links' => $links,
        ];

    }

}
