<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public function category()
    {
        return $this->belongsTo(PermissionCategory::class);
    }
}
