<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SsoController extends Controller
{
    /**
     * Redirect the user to the Azure AD authentication page.
     */
    public function redirect()
    {
        return Socialite::driver('azure')->redirect();
    }

    /**
     * Obtain the user information from Azure AD.
     */
    public function callback()
    {
        try {
            $azureUser = Socialite::driver('azure')->user();
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'SSO Authentication failed.');
        }

        // Find the user by their corporate email
        $user = User::where('email', $azureUser->getEmail())->first();

        if (! $user) {
            return redirect('/login')->with('error', 'Your corporate account is not registered in this portal.');
        }

        // Verify the user belongs to the current tenant context (if applicable)
        $tenant = session('tenant');
        if ($tenant && $user->tenant_id !== $tenant->id) {
            return redirect('/login')->with('error', 'Unauthorized access for this tenant.');
        }

        // Log the user in bypassing the password check
        Auth::login($user);

        return redirect()->intended('/dashboard');
    }
}
