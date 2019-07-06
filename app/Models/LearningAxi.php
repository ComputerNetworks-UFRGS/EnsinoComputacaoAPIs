<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningAxi extends Model
{

    public function objects()
    {
        return $this->hasMany(LearningObject::class, 'learning_axis_id');
    }

}
