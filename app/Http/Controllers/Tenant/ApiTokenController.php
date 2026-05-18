<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiTokenController extends Controller
{
    /**
     * Display a listing of the user's API tokens.
     */
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'tokens' => $request->user()->tokens,
        ]);
    }

    /**
     * Create a new API token.
     */
    public function store(Request $request)
    {
        $request->validate([
            'token_name' => 'required|string|max:255',
            'abilities' => 'nullable|array',
        ]);

        /** @var \App\Models\User $user */
        $user = $request->user();
        $token = $user->createToken($request->token_name, $request->abilities ?? ['*']);

        if ($request->wantsJson()) {
            return response()->json([
                'token' => $token->plainTextToken,
            ], 201);
        }

        return redirect()->back()->with('token', $token->plainTextToken);
    }

    /**
     * Revoke a specific API token.
     */
    public function destroy(Request $request, string $tokenId)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $user->tokens()->where('id', $tokenId)->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Token revoked successfully.',
            ]);
        }

        return redirect()->back()->with('message', 'Token revoked successfully.');
    }
}
