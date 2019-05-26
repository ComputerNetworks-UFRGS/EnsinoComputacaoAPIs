<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function list()
    {
        $this->authorize('has-permission', 'users.edit|role.list');

        return Permission::with('category')->get();
    }

}
