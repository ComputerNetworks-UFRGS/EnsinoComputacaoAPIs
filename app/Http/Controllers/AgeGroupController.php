<?php

namespace App\Http\Controllers;

use App\Models\AgeGroup;
use App\Http\Resources\AgeGroupResource;

class AgeGroupController extends Controller
{
    public function list()
    {
        return AgeGroupResource::collection(AgeGroup::get());
    }

}
