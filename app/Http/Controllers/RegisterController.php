<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invite;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        Log::info('In Register method');
        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            Invite::where('code', $validated['invite_code'])
                  ->first()
                    ->update([
                        'used' => true,
                        'user_id' => $user->id
                    ]);
            DB::commit();

            event(new Registered($user));

            return response()->json(['message' => 'Registration successful.', 'user' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Registration failed", ['error' => $e->getMessage()]);

            return response()->json(['message' => 'Registration failed.'], 422);
        }
    }
}
