<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    const TYPE_BASIC = 1;

    public function taskSkill()
    {
        return $this->hasMany(TaskSkill::class);
    }

    public function mainSkill()
    {
        $task_skill = $this->taskSkill()->first();
        if($task_skill) {
            $skill_id = $task_skill->skill_id;
            $skill = Skill::with([
                'ageGroup' => function($join) {
                    $join->select('id', 'name');
                }])->find($skill_id);

            $data = $skill->only([
                'id',
                'code',
                'name',
                'ageGroup'
            ]);

            return [
                'habilidade_id' => $data['id'],
                'habilidade_nome' => $data['name'],
                'habilidade_codigo' => $data['code'],
                'idade_nome' => $data['ageGroup']['name'],
            ];
        }
        return false;
    }

    public function addSkill($skill_id)
    {
        $task_skill = new TaskSkill();
        $task_skill->task_id = $this->id;
        $task_skill->skill_id = $skill_id;
        $task_skill->type = TaskSkill::TYPE_PRIMARY;
        $task_skill->save();
    }

}
