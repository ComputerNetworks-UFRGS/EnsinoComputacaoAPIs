<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LearningAxis;

class AxisController extends Controller
{


    public function list(Request $req)
    {
        return LearningAxis::orderBy('name')->get();
    }


}
