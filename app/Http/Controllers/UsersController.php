<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UsersController extends Controller
{
    public function list()
    {
        return User::with('role')->get();
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->role_id = $request->role_id ? $request->role_id : null;
        $user->save();
    }

}
