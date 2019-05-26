<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\UserTask;

class Task extends Model
{
    const TYPE_BASIC = 1;

    const STATUS_FOR_REVIEW = 1;
    const STATUS_DENIED = 2;
    const STATUS_DENIED_NEED_FIX = 3;
    const STATUS_APPROVED = 4;
    const STATUS_PUBLISHED = 5;

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'task_skills', 'task_id', 'skill_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tasks', 'task_id', 'user_id');
    }

    public function taskSkill()
    {
        return $this->hasMany(TaskSkill::class);
    }

    public function userTask()
    {
        return $this->hasMany(UserTask::class);
    }

    // public function mainSkill()
    // {
    //     $skill = $this->skills()->first();
    //     if($skill) {

    //         $data = $skill->only([
    //             'id',
    //             'code',
    //             'name',
    //             'ageGroup'
    //         ]);

    //         return [
    //             'habilidade_id' => $data['id'],
    //             'habilidade_nome' => $data['name'],
    //             'habilidade_codigo' => $data['code'],
    //             'idade_nome' => $data['ageGroup']['name'],
    //         ];
    //     }
    //     return false;
    // }

    public function addSkill($skill_id)
    {
        $task_skill = new TaskSkill();
        $task_skill->task_id = $this->id;
        $task_skill->skill_id = $skill_id;
        $task_skill->type = TaskSkill::TYPE_PRIMARY;
        $task_skill->save();
    }

    public function creator()
    {
        $user_task = $this->userTask()
            ->where('task_id', $this->id)
            ->where('role', UserTask::ROLE_OWNER)
            ->first();

        if($user_task) {
            $user_id = $user_task->user_id;
            return User::find($user_task->user_id)->only([
                'id',
                'name'
            ]);
        }
        return false;
    }

}
