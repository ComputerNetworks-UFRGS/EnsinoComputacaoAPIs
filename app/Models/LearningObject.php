<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningObject extends Model
{

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function ageGroup()
    {
        return $this->belongsTo(AgeGroup::class);
    }

    public function axis()
    {
        return $this->belongsTo(LearningAxis::class, 'learning_axis_id');
    }

}
