<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GraphJsPlumbResource extends JsonResource
{

    public function toArray($request)
    {

        $nodes = [];
        foreach ($this->nodes as $node) {

            $nodes[] = [
                'id' => 'node' . $node->id,
                'title' => $node->title,
                'type' => $node->type,
                'age_group' => $node->learnigObject->ageGroup,
                'x' => ($node->position_x) . 'px',
                'y' => ($node->position_y) . 'px',
                'dependencies' => $node->dependencies->transform(function ($dependency) {
                    return $dependency->id;
                }),
                'dependents' => $node->dependents->transform(function ($dependent) {
                    return $dependent->id;
                })
            ];
        }

        $links = [];
        foreach ($this->edges as $edge) {
            $links[] = [
                'id' => "{$edge->graph_id}-{$edge->node_from_id}-{$edge->node_to_id}",
                'source' => 'node' . $edge->node_from_id,
                'target' => 'node' . $edge->node_to_id,
            ];
        }

        $groups = collect($nodes)->groupBy(function($n) {
            return $n['age_group']['id'];
        })->toArray();

        $ggg = [];
        foreach($groups as $k => $nodes) {
            $g = [];
            $g['id'] = 'group' . $k;
            $g['height'] = 200;
            $g['x'] = 0;
            $g['y'] = 0;
            $g['nodes'] = $nodes;
            $ggg[] = $g;
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'groups' => $ggg,
            'edges' => $links,
        ];
    }
}
