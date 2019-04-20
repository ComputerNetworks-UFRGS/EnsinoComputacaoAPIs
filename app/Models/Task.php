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

}
