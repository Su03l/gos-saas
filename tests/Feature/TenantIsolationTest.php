<?php

declare(strict_types=1);

use App\Models\Meeting;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('a user from one tenant cannot access a meeting from another tenant', function () {
    // 1. Create Tenant A and a Meeting
    $tenantA = Tenant::factory()->create(['domain' => 'comp-a.test']);
    $meetingA = Meeting::factory()->create(['tenant_id' => $tenantA->id]);
    $userA = User::factory()->create(['tenant_id' => $tenantA->id]);

    // 2. Create Tenant B and a Meeting
    $tenantB = Tenant::factory()->create(['domain' => 'comp-b.test']);
    $meetingB = Meeting::factory()->create(['tenant_id' => $tenantB->id]);

    // 3. Act as User A on Tenant A domain
    $this->actingAs($userA)
        ->withHeader('Host', 'comp-a.test');

    // 4. Attempt to access Tenant B's meeting via ID
    // Note: In our architecture, the TenantIsolationMiddleware should catch this 
    // because it scopes all queries to the current tenant.
    $response = $this->get("/dashboard/meetings/{$meetingB->id}");

    // 5. Assert Access is Denied or Not Found
    $response->assertStatus(404); // Should be 404 because the ID doesn't exist in Tenant A's database scope
});

test('a user can only see meetings belonging to their own tenant', function () {
    $tenantA = Tenant::factory()->create(['domain' => 'comp-a.test']);
    $meetingA = Meeting::factory()->create(['tenant_id' => $tenantA->id, 'title' => 'Alpha Meeting']);
    $userA = User::factory()->create(['tenant_id' => $tenantA->id]);

    $tenantB = Tenant::factory()->create(['domain' => 'comp-b.test']);
    $meetingB = Meeting::factory()->create(['tenant_id' => $tenantB->id, 'title' => 'Beta Meeting']);

    $response = $this->actingAs($userA)
        ->withHeader('Host', 'comp-a.test')
        ->get('/dashboard/meetings');

    $response->assertStatus(200);
    $response->assertSee('Alpha Meeting');
    $response->assertDontSee('Beta Meeting');
});
