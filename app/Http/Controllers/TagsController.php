<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;

class TagsController extends Controller
{

    public function list(Request $req)
    {
        return Tag::where('published', true)->get();
    }
}
