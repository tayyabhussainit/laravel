<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        return response()->json(['token' => $user->createToken('API Token')->accessToken]);
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['token' => Auth::user()->createToken('API Token')->accessToken]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);

    }
}
