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

}
