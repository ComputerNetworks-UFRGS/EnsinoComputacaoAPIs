<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GraphStepsResource extends JsonResource
{

    private $steps = [];
    private $tracked = [];

    public function toArray($request)
    {
        // TODO: tratar loops...
        $nodes = $this->nodes->filter(function($node) {
            return count($node->dependencies) <= 0;
        });
        $this->groupSteps($nodes);
        $this->removeDuplicates();
        return $this->getFormattedSteps();

    }

    /**
     * - primeiro nível é composto pelos nodos sem nenhuma dependência
     * - para cada nodo da lista, percorre seus dependentes
     * - registra cada um dos dependentes ainda não incluídos
     * - incrementa contador de nível
     * - repete processo com lista de dependentes recém montada
     */
    private function groupSteps($nodes)
    {
        $dependents = [];
        foreach($nodes as $node) {
            foreach($node->dependents as $dependent) {
                $dependents[] = $dependent;
            }
        }
        $this->steps[] = $nodes;
        if(count($dependents) > 0) {
            $this->groupSteps($dependents);
        }
    }

    private function removeDuplicates()
    {
        $count = count($this->steps);
        for($i = $count - 1; $i >= 0; $i--) {
            foreach($this->steps[$i] as $j => $node) {
                if(isset($this->tracked[$node->id])) {
                    unset($this->steps[$i][$j]);
                }
                $this->tracked[$node->id] = true;
            }
        }
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
