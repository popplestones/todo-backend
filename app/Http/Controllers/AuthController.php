<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $user->tokens()->delete();
            $token = $user->createToken('Todo Application')->plainTextToken;

            return response()->json([
                'message' => 'Logged in successfully.',
                'user' => $user,
                'token' => $token
            ], 200);
        }

        return response()->json(['message' => 'The provided credentials do not match our records.'], 401);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
