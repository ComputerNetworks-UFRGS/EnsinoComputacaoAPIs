<?php

namespace App\Http\Controllers;

use App\Models\LearningStage;

class LearningStageController extends Controller
{
    public function list()
    {
        return LearningStage::get();
    }

}
