<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GraphYearsResource extends JsonResource
{

    private $steps = [];
    private $tracked = [];

    public function toArray($request)
    {
        // TODO: tratar loops...
        $this->groupSteps($this->nodes);
        return $this->steps;
        // return $this->getFormattedSteps();
        // $this->removeDuplicates();


    }

    /**
     * - agrupa por learning_stage
     */
    private function groupSteps($nodes)
    {
        $this->steps = $nodes->groupBy(function ($item, $key) {
            if($item->learnigObject && $item->learnigObject->skills) {
                $skill = $item->learnigObject->skills->first();
                return $skill->ageGroup->id;
            } else {
                return '????';
            }
        });
        // $dependents = [];
        // foreach($nodes as $node) {
        //     foreach($node->dependents as $dependent) {
        //         $dependents[] = $dependent;
        //     }
        // }
        // $this->steps[] = $nodes;
        // if(count($dependents) > 0) {
        //     $this->groupSteps($dependents);
        // }
    }

    private function getFormattedSteps()
    {
        $steps = [];
        foreach($this->steps as $nodes) {
            $step = [];
            foreach($nodes as $node) {

                $dependencies = $node->dependencies->transform(function($dependency) {
                    return $dependency->id;
                });
                $dependents = $node->dependents->transform(function($dependent) {
                    return $dependent->id;
                });
                $step[] = [
                    'id' => $node->id,
                    'title' => $node->title,
                    'dependencies' => $dependencies,
                    'dependents' => $dependents,
                ];
            }
            $steps[] = $step;
        }

        return $steps;
    }


}
