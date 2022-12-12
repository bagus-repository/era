<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required|alpha_num|min:6',
        ]);

        if (Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'user' => auth()->user(),
                'token' => auth()->user()->createToken('api')->plainTextToken,
            ]);
        }else{
            abort(400, 'Kredensial login salah');
        }
    }
}
