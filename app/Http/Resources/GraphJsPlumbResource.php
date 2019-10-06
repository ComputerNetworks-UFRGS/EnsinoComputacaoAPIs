<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GraphJsPlumbResource extends JsonResource
{
    // private $steps = [];
    // private $tracked = [];

    public function toArray($request)
    {

        $groupByYear = $request->groupByYear;
        $groupByStep = $request->groupByStep; // hierarquia

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
            'nodes' => ($groupByYear || $groupByStep) ? [] : $nodes,
            'edges' => $links,
            'groups' => $groupByStep ? $this->groupNodesBySteps($nodes) : ($groupByYear ? $this->groupNodesByAgeGroup($nodes) : []),
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
                    'height' => $this->height,
                    'width' => $this->width,
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

    private function groupNodesBySteps($nodes)
    {
        return [];
        // $nodes = $this->nodes->filter(function ($node) {
        //     return count($node['dependencies']) <= 0;
        // });
        // $this->groupSteps($nodes);
        // $this->removeDuplicates();
        // $steps = $this->getFormattedSteps();

        // $groups = [];
        // foreach ($steps as $k => $nodes) {
        //     $groupId = $k;
        //     $groups[$groupId] = [
        //         'id' => 'group' . $groupId,
        //         'title' => $groupId,
        //         'height' => 100,
        //         'width' => 400,
        //         'x' => 0,
        //         'y' => 0,
        //         'nodes' => $nodes
        //     ];
        // }

        // return $groups;
    }

    /**
     * - primeiro nível é composto pelos nodos sem nenhuma dependência
     * - para cada nodo da lista, percorre seus dependentes
     * - registra cada um dos dependentes ainda não incluídos
     * - incrementa contador de nível
     * - repete processo com lista de dependentes recém montada
     */
    // private function groupSteps($nodes)
    // {
    //     $dependents = [];
    //     foreach ($nodes as $node) {
    //         foreach ($node['dependents'] as $dependent) {
    //             $dependents[] = $dependent;
    //         }
    //     }
    //     $this->steps[] = $nodes;
    //     if (count($dependents) > 0) {
    //         $this->groupSteps($dependents);
    //     }
    // }

    // private function removeDuplicates()
    // {
    //     $count = count($this->steps);
    //     for ($i = $count - 1; $i >= 0; $i--) {
    //         foreach ($this->steps[$i] as $j => $node) {
    //             if (isset($this->tracked[$node->id])) {
    //                 unset($this->steps[$i][$j]);
    //             }
    //             $this->tracked[$node->id] = true;
    //         }
    //     }
    // }

    // private function getFormattedSteps()
    // {
    //     $steps = [];
    //     foreach ($this->steps as $nodes) {
    //         $step = [];
    //         foreach ($nodes as $node) {

    //             $dependencies = $node->dependencies->transform(function ($dependency) {
    //                 return $dependency->id;
    //             });
    //             $dependents = $node->dependents->transform(function ($dependent) {
    //                 return $dependent->id;
    //             });
    //             $step[] = [
    //                 'id' => $node->id,
    //                 'title' => $node->title,
    //                 'dependencies' => $dependencies,
    //                 'dependents' => $dependents,
    //             ];
    //         }
    //         $steps[] = $step;
    //     }

    //     return $steps;
    // }
}
