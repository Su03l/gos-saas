<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleDelegation
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $user = $request->user()) {
            return $next($request);
        }

        $today = now()->toDateString();

        // Check if the current user has any active delegations
        $activeDelegations = DB::table('role_delegations')
            ->where('delegate_id', $user->id)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->get();

        foreach ($activeDelegations as $delegation) {
            // Temporarily grant the delegated role to the user's session or runtime permissions
            if (method_exists($user, 'assignRole')) {
                $user->assignRole($delegation->role_name);
            }
        }

        return $next($request);
    }
}
