<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\User;

class RoleController extends Controller
{
    public function list()
    {
        return Role::get();
    }

    public function detail($id)
    {
        return Role::with([
            'permissions' => function($join) {
                $join->select('id', 'code', 'description');
            }
        ])->find($id);
    }

    public function create(Request $request)
    {
        $role = new Role();
        $role->title = $request->title;
        $role->description = $request->description;
        $role->save();
        return 'ok';
    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $role->permissions()->sync($request->permissions);
        $role->save();
    }

    public function delete($id)
    {
        $role = Role::find($id);
        User::where('role_id', $role->id)->update(['role_id' => null]);
        $role->permissions()->sync([]);
        $role->delete();
    }

}
