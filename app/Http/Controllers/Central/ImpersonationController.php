<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    /**
     * Impersonate a user within a specific tenant.
     */
    public function impersonate(Request $request, Tenant $tenant, User $user)
    {
        // Strict security: Only Super Admins from the central domain can impersonate
        if (! $request->user()?->hasRole('Super_Admin')) {
            abort(403, 'Unauthorized');
        }

        // Store original Super Admin ID in session
        session(['original_super_admin_id' => Auth::id()]);

        // Log in as the target user
        Auth::login($user);

        // Redirect to the tenant's dashboard
        return redirect()->away($tenant->domain . '/dashboard');
    }

    /**
     * Leave impersonation and return to the Super Admin account.
     */
    public function leave(Request $request)
    {
        if (! session()->has('original_super_admin_id')) {
            abort(404);
        }

        $originalAdmin = User::findOrFail(session('original_super_admin_id'));

        // Restore original session
        Auth::login($originalAdmin);
        session()->forget('original_super_admin_id');

        return redirect()->route('central.dashboard');
    }
}
