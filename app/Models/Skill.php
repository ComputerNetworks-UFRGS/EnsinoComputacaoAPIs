<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AgeGroup;

class Skill extends Model
{

    public function ageGroup()
    {
        return $this->belongsTo(AgeGroup::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_skills', 'skill_id', 'task_id');
    }

    public function object()
    {
        return $this->belongsTo(LearningObject::class, 'learning_object_id');
    }

}
