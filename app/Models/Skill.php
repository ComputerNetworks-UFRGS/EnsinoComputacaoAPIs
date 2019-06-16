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

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_skills', 'skill_id', 'task_id');
    }

}
