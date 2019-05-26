<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    public function detail(Request $request)
    {
        $id = Auth::user()->id;
        $user = User::with(['role', 'role.permissions'])->find($id);
        if($user->role && $user->role->permissions) {
            $permissions = $user->role->permissions;
            $user->permissions = $permissions->map(function($permission) {
                return $permission->code;
            });
        }

        return collect($user)->except('role');
    }
}
