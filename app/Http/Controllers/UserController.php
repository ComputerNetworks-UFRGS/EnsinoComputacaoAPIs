<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    public function detail(Request $request)
    {
        return Auth::user();
        // $user_id = auth()->id;
        // $user = User::find($user_id);
        // return [
        //     'id' => $user_id,
        // ];
    }
}
