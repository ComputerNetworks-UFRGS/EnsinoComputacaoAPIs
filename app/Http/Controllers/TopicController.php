<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\UserTask;
use App\Models\TaskSkill;
use App\Models\Skill;
use App\Http\Requests\StoreTask;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Mews\Purifier\Facades\Purifier;
use App\Models\LearningStage;

class TopicController extends Controller
{

    public function list()
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
                's.name AS title',
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
                            'is_leaf' => $depth == 1,
                            'items' => $groupFn($items, $depth - 1),
                        ];
                    })
                    ->sortBy('title')
                    ->values();

            } else {

                return $nodes->map(function($item) use($to_remove) {
                    return collect($item)->except($to_remove);
                });

            }

        };

        return [
            'title' => 'Ensino Computacional',
            'items' => $groupFn($nodes, count($tree_struct)),
        ];

    }

}
