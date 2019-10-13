<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    public function makeKey($name)
    {
        return Str::slug($name, '-');
    }
}
