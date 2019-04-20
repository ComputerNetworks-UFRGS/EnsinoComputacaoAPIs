<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LearningStage;

class SkillController extends Controller
{

    public function years()
    {
        $skills = DB::table('skills AS s')
            ->join('learning_stages AS ls', function($join) {
               $join->on('ls.id', '=', 's.learning_stage_id')
                    ->where('ls.code', LearningStage::CODE_ENSINO_COMPUTACIONAL);
            })
            ->join('age_groups AS ag', 'ag.id', '=', 's.age_group_id')
            ->join('topics AS objeto', 'objeto.id', '=', 's.topic_id')
            ->join('topics AS eixo', 'eixo.id', '=', 'objeto.parent_id')
            ->select('ag.name AS idade_nome',
                'ag.code AS idade_codigo',
                'ag.age_from AS idade_min',
                'ag.age_to AS idade_max',
                'objeto.name AS objeto_nome',
                's.id AS habilidade_id',
                's.code AS habilidade_codigo',
                's.name AS habilidade_nome',
                's.sequential_number AS habilidade_numero',
                'eixo.name AS eixo_nome',
                'eixo.code AS eixo_code')
            ->orderByRaw('ag.age_from, s.sequential_number')
            ->get();

        return $skills->groupBy('idade_codigo')
            ->map(function($item, $key) {
                return $item->groupBy('objeto_nome');
            });
    }

    public function tree()
    {
        $nodes = DB::table('topics AS eixo')
            ->join('topic_types AS tt', function($join) {
                $join->on('tt.id', '=', 'eixo.type_id')
                    ->where('tt.is_head', 1);
            })
            ->join('learning_stages AS ls', function($join) {
                $join->on('ls.id', '=', 'tt.learning_stage_id')
                    ->where('ls.code', LearningStage::CODE_ENSINO_COMPUTACIONAL);
            })
            ->join('topics AS objeto', 'objeto.parent_id', '=', 'eixo.id')
            ->join('skills AS s', 's.topic_id', '=', 'objeto.id')
            ->select(
                'eixo.id AS eixo_id',
                'eixo.name as eixo_nome',
                'objeto.id as objeto_id',
                'objeto.name as objeto_nome',
                's.id AS id',
                's.name AS name',
                's.code AS code')
            ->get();


        $tree_struct = ['objeto', 'eixo']; // leaf to head order

        $to_remove = [];
        foreach($tree_struct as $tree_node) {
            $to_remove[] = $tree_node . '_id';
            $to_remove[] = $tree_node . '_nome';
        }

        $groupFn = function($nodes, $depth) use(&$groupFn, $tree_struct, $to_remove) {

            if($depth > 0) {

                $id = $tree_struct[$depth - 1] . '_id';
                $title = $tree_struct[$depth - 1] . '_nome';

                return $nodes->groupBy($id)
                    ->map(function($items, $key) use(&$groupFn, $id, $title, $depth) {
                        return [
                            'id' => $items[0]->{$id},
                            'title' => $items[0]->{$title},
                            'items' => $groupFn($items, $depth - 1),
                        ];
                    })->sortBy('title')->values();

            } else {

                return $nodes->map(function($item) use($to_remove) {
                    return collect($item)->except($to_remove);
                });

            }

        };

        return $groupFn($nodes, count($tree_struct));
    }

}
