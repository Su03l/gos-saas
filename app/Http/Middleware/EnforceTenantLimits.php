<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceTenantLimits
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = session('tenant');

        if (! $tenant) {
            return $next($request);
        }

        // 1. Check Subscription Status
        if ($tenant->subscription_status === 'suspended') {
            abort(403, 'Your organization\'s subscription has been suspended. Please contact support.');
        }

        // 2. Example: Check User Limits (only on creation routes)
        if ($request->is('*/users') && $request->isMethod('POST')) {
            $currentUserCount = User::count();
            if ($currentUserCount >= $tenant->max_users) {
                return redirect()->back()->with('error', 'User limit reached for your current plan.');
            }
        }

        return $next($request);
    }
}
