<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LearningStage;
use App\Models\Skill;

class SkillController extends Controller
{

    public function list()
    {
        $this->authorize('has-permission', 'skill.list');
        return Skill::orderBy('name')->get();
    }

    public function detail($id)
    {
        $this->authorize('has-permission', 'skill.detail');
        return Skill::find($id);
    }

    public function create(Request $request)
    {
        $this->authorize('has-permission', 'skill.create');
        $skill = new Skill();
        $skill->code = $request->code;
        $skill->name = $request->name;
        $skill->sequential_number = $request->sequential_number;
        $skill->learning_object_id = $request->learning_object_id;
        $skill->age_group_id = $request->age_group_id;
        $skill->save();
        return 'ok';
    }

    public function update(Request $request, $id)
    {
        $this->authorize('has-permission', 'skill.edit');
        $skill = Skill::find($id);
        $skill->code = $request->code;
        $skill->name = $request->name;
        $skill->sequential_number = $request->sequential_number;
        $skill->learning_object_id = $request->learning_object_id;
        $skill->age_group_id = $request->age_group_id;
        // $skill->topic_id = $request->topic_id;
        $skill->save();
    }

    public function delete($id)
    {
        $this->authorize('has-permission', 'skill.delete');
        $skill = Skill::find($id);
        $skill->tasks()->sync([]);
        $skill->delete();
    }

    public function years()
    {
        $skills = DB::table('skills AS s')
            ->join('learning_objects AS objeto', 'objeto.id', '=', 's.learning_object_id')
            ->join('learning_axis AS eixo', 'eixo.id', '=', 'objeto.learning_axis_id')
            ->join('learning_stages AS ls', 'ls.id', '=', 'eixo.learning_stages_id')
            ->join('age_groups AS ag', 'ag.id', '=', 's.age_group_id')
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
                'eixo.description AS eixo_code')
            ->orderByRaw('ag.age_from, objeto.name')
            ->get();

        return $skills->groupBy('idade_codigo')
            ->map(function($item, $key) {
                return [
                    'idade' => $item->first(),
                    'objects' => $item->groupBy('objeto_nome'),
                ];
            });
    }

    public function tree()
    {
        return LearningStage::where('code', LearningStage::CODE_ENSINO_COMPUTACIONAL)
            ->with(['axis', 'axis.objects' => function($join) {
                $join->orderBy('name');
            }, 'axis.objects.skills'])
            ->first();
    }

}
