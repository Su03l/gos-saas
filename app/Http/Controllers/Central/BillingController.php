<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    /**
     * Create a Stripe Checkout session for a selected plan.
     */
    public function checkout(Request $request, string $plan): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $tenant = $user->tenant;

        if (! $tenant) {
            return redirect()->back()->with('error', 'No tenant associated with your account.');
        }

        // Mapping simple plan slugs to Stripe Price IDs
        $priceId = match ($plan) {
            'starter' => env('STRIPE_STARTER_PRICE_ID', 'price_starter'),
            'pro' => env('STRIPE_PRO_PRICE_ID', 'price_pro'),
            'enterprise' => env('STRIPE_ENTERPRISE_PRICE_ID', 'price_enterprise'),
            default => $plan,
        };

        return $tenant->newSubscription($plan, $priceId)
            ->checkout([
                'success_url' => route('tenant.dashboard') . '?checkout=success',
                'cancel_url' => route('tenant.dashboard') . '?checkout=cancelled',
            ]);
    }

    /**
     * Redirect to the Stripe Customer Portal for invoice management.
     */
    public function portal(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $tenant = $user->tenant;

        if (! $tenant) {
            return redirect()->back()->with('error', 'No tenant associated with your account.');
        }

        return $tenant->redirectToBillingPortal(route('tenant.dashboard'));
    }
}
