<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningStage extends Model
{
    const CODE_ENSINO_COMPUTACIONAL = 'EC';

    public function axis()
    {
        return $this->hasMany(LearningAxis::class, 'learning_stages_id');
    }

}
