<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\UserTask;

class Task extends Model
{
    const TYPE_BASIC = 1;
    const TYPE_LINK = 2;

    const STATUS_CREATED = 0;
    const STATUS_FOR_REVIEW = 1;
    const STATUS_DENIED = 2;
    const STATUS_DENIED_NEED_FIX = 3;
    const STATUS_PUBLISHED = 4;
    const STATUS_REVIEWED = 5;

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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function attachments()
    {
        return $this->hasMany(TaskAttachment::class);
    }

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
            return User::find($user_task->user_id)->only([
                'id',
                'name'
            ]);
        }
        return false;
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'task_tags', 'task_id', 'tag_id');
    }

    public static function getTypeLabels()
    {
        return [
            self::TYPE_BASIC => 'criar nova atividade',
            self::TYPE_LINK => 'referência externa',
        ];
    }

}
