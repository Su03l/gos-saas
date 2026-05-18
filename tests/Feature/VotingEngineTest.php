<?php

declare(strict_types=1);

use App\Models\Committee;
use App\Models\Resolution;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Vote;
use App\Services\VotingEngineService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('voting engine calculates results based on quorum and weights', function () {
    // 1. Setup Tenant and Committee
    $tenant = Tenant::create([
        'name' => 'Test Corp',
        'domain' => 'test',
        'sqlite_database_path' => 'database/database.sqlite',
    ]);

    $committee = Committee::create([
        'name' => 'Board of Directors',
        'quorum_percentage' => 50,
    ]);

    // 2. Setup Users and Committee Membership
    $user1 = User::factory()->create(['name' => 'Member A', 'tenant_id' => $tenant->id]);
    $user2 = User::factory()->create(['name' => 'Member B', 'tenant_id' => $tenant->id]);
    $user3 = User::factory()->create(['name' => 'Member C', 'tenant_id' => $tenant->id]);

    $committee->members()->attach([
        $user1->id => ['role_in_committee' => 'chairman'],
        $user2->id => ['role_in_committee' => 'member'],
        $user3->id => ['role_in_committee' => 'member'],
    ]);

    // 3. Create Resolution
    $resolution = Resolution::create([
        'committee_id' => $committee->id,
        'title' => 'Expansion Plan',
        'legally_binding_text' => 'Approved budget of $1M.',
        'state' => 'voting',
        'is_circular' => true,
        'voting_deadline' => now()->addDays(1),
    ]);

    $service = new VotingEngineService;

    // 4. Cast Votes (2 out of 3 members vote = 66% quorum, reached)
    // Chairman (User 1) approves with weight 1.0
    $service->castVote($resolution, $user1, 'approve', '127.0.0.1');

    // Member (User 2) rejects with weight 1.0 (but let's simulate a weight change)
    Vote::where('user_id', $user2->id)->delete(); // Cleanup if updateOrCreate was called
    Vote::create([
        'resolution_id' => $resolution->id,
        'user_id' => $user2->id,
        'vote_cast' => 'reject',
        'vote_weight' => 0.5,
        'ip_address' => '127.0.0.1',
    ]);

    // 5. Calculate Result
    // Force deadline passed for calculation logic if needed,
    // but the service logic also triggers if everyone voted (here only 2/3 voted)
    // So let's mock the deadline passed
    $resolution->voting_deadline = now()->subMinute();
    $resolution->save();

    $service->calculateResult($resolution);

    // 6. Assertions
    // Approve (1.0) > Reject (0.5)
    expect($resolution->fresh()->state)->toBe('approved');
});
