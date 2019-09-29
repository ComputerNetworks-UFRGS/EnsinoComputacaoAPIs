<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GraphJsPlumbResource extends JsonResource
{

    public function toArray($request)
    {

        $nodes = [];
        foreach ($this->nodes as $node) {

            $skills = @$node->learnigObject->skills;

            $nodes[] = [
                'id' => 'node-' . $node->id,
                'title' => $node->title,
                'type' => $node->type,
                'age_group' => $skills ? new AgeGroupResource($skills[0]->ageGroup) : false,
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
                'source' => 'node-' . $edge->node_from_id,
                'target' => 'node-' . $edge->node_to_id,
            ];
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'nodes' => $nodes,
            'edges' => $links,
        ];
    }
}
