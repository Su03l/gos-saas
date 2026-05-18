<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTwoFactorEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->hasRole('Board_Member')) {
            // Logic assuming Laravel Fortify or similar is used
            // If the user doesn't have a 2FA secret or hasn't confirmed it
            if (! $user->two_factor_secret) {
                return redirect()->route('two-factor.setup')
                    ->with('warning', 'Board Members are required to enable Two-Factor Authentication for secure access.');
            }
        }

        return $next($request);
    }
}
