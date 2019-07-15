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
        $this->steps = $nodes->groupBy(function ($item, $key) {
            if($item->learnigObject && $item->learnigObject->ageGroup) {
                return $item->learnigObject->ageGroup->id;
            } else {
                return '????';
            }
        });
        return $this->steps;
        // return $this->getFormattedSteps();
        // $this->removeDuplicates();


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
