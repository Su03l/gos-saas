<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MobileAuthController extends Controller
{
    /**
     * Authenticate a mobile device and return a Sanctum token.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'device_name' => ['required', 'string'],
            'two_factor_code' => ['nullable', 'string'], // Placeholder for 2FA validation
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('The provided credentials are incorrect.')],
            ]);
        }

        // Logic for 2FA check would go here if enabled for the user
        if ($user->two_factor_secret && ! $request->two_factor_code) {
             return response()->json(['message' => '2FA_REQUIRED'], 403);
        }

        // Create a specific token for mobile devices
        $token = $user->createToken($request->device_name ?: 'mobile-device')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
        ]);
    }
}
