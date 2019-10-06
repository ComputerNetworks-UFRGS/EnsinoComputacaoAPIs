<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GraphJsPlumbResource extends JsonResource
{

    public function toArray($request)
    {

        $groupByYear = $request->groupByYear;

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


        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'nodes' => $groupByYear ? [] : $nodes,
            'edges' => $links,
            'groups' => $groupByYear ? $this->groupNodesByAgeGroup($nodes) : [],
        ];
    }

    private function groupNodesByAgeGroup($nodes)
    {

        $groups = [];
        foreach ($nodes as $node) {
            $ageGroupId = $node['age_group']->id;
            if (!isset($groups[$ageGroupId])) {
                $groups[$ageGroupId] = [
                    'id' => 'group' . $ageGroupId,
                    'title' => $node['age_group']['name'],
                    'min_age' => $node['age_group']['age_from'],
                    'height' => 100,
                    'width' => 400,
                    'x' => 0,
                    'y' => 0,
                    'nodes' => []
                ];
            }

            $groups[$ageGroupId]['nodes'][] = $node;
        }

        usort($groups, function ($a, $b) {
            return $a['min_age'] > $b['min_age'];
        });

        return $groups;
    }
}
