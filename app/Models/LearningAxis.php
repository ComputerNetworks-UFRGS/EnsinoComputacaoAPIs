<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningAxis extends Model
{
    protected $table = 'learning_axis';

    public function objects()
    {
        return $this->hasMany(LearningObject::class, 'learning_axis_id');
    }

}
