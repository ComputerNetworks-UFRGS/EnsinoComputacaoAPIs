<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Role;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if($user && Hash::check($request->password, $user->password)) {
            $user->api_token = Str::random(80);
            $user->save();
            return response()->json([
                'name' => $user->name,
                'token' => $user->api_token,
            ]);
        }

        return response()->json([
            'message' => 'E-mail ou senha inválida.',
        ], 400);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $role = Role::where('default', 1)->first();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->api_token = Str::random(80);
        $user->role_id = $role ? $role->id : null;
        $user->save();

        return response()->json([
            'name' => $user->name,
            'token' => $user->api_token,
        ]);
    }

}
