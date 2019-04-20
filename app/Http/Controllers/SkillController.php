<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LearningStage;

class SkillController extends Controller
{
    public function list()
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

}
