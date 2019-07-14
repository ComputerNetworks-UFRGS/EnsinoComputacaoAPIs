<?php

namespace App\Http\Controllers;

use App\Models\AgeGroup;

class AgeGroupController extends Controller
{
    public function list()
    {
        return AgeGroup::get();
    }

}
