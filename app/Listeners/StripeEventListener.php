<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Models\Tenant;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    /**
     * Handle received Stripe webhooks.
     */
    public function handle(WebhookReceived $event): void
    {
        $payload = $event->payload;
        $type = $payload['type'] ?? null;

        if (! $type) {
            return;
        }

        $stripeId = $payload['data']['object']['customer'] ?? null;

        if (! $stripeId) {
            return;
        }

        $tenant = Tenant::where('stripe_id', $stripeId)->first();

        if (! $tenant) {
            return;
        }

        match ($type) {
            'invoice.payment_succeeded' => $tenant->update(['subscription_status' => 'active']),
            'invoice.payment_failed', 'customer.subscription.deleted' => $tenant->update(['subscription_status' => 'suspended']),
            default => null,
        };
    }
}
