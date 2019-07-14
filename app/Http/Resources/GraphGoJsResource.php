<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GraphGoJsResource extends JsonResource
{

    public function toArray($request)
    {

        $nodes = [];
        foreach($this->nodes as $node) {

            $skills = @$node->learnigObject->skills;

            $nodes[] = [
                'id' => $node->id,
                'title' => $node->title,
                'type' => $node->type,
                'age_group' => $skills ? new AgeGroupResource($skills[0]->ageGroup) : false,
            ];
        }

        $links = [];
        foreach($this->edges as $edge) {
            $links[] = [
                'id' => "{$edge->graph_id}-{$edge->node_from_id}-{$edge->node_to_id}" ,
                'source' => $edge->node_from_id,
                'destination' => $edge->node_to_id,
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
