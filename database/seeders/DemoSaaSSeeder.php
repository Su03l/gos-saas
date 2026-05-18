<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\AgendaItem;
use App\Models\Committee;
use App\Models\Meeting;
use App\Models\Resolution;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSaaSSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a Demo Tenant
        $tenant = Tenant::create([
            'name' => 'Acme Corporation',
            'domain' => 'acme.governance.test',
            'sqlite_database_path' => database_path('tenant_acme.sqlite'),
            'subscription_status' => 'active',
            'max_users' => 50,
            'max_storage_mb' => 10240,
        ]);

        // 2. Create 5 Users with roles
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@acme.test',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant->id,
        ])->assignRole('Super_Admin');

        $secretary = User::create([
            'name' => 'Board Secretary',
            'email' => 'secretary@acme.test',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant->id,
        ])->assignRole('Committee_Secretary');

        $members = collect(['Member One', 'Member Two', 'Member Three'])->map(function ($name, $index) use ($tenant) {
            return User::create([
                'name' => $name,
                'email' => "member" . ($index + 1) . "@acme.test",
                'password' => Hash::make('password'),
                'tenant_id' => $tenant->id,
            ])->assignRole('Board_Member');
        });

        // 3. Create 2 Committees
        $board = Committee::create([
            'name' => 'Board of Directors',
            'description' => 'Main governing body of Acme Corp.',
        ]);

        $audit = Committee::create([
            'name' => 'Audit Committee',
            'description' => 'Responsible for financial oversight.',
        ]);

        // Add members to board
        $board->members()->attach($admin->id, ['role_in_committee' => 'Chair']);
        $board->members()->attach($secretary->id, ['role_in_committee' => 'Secretary']);
        foreach ($members as $member) {
            $board->members()->attach($member->id, ['role_in_committee' => 'Member']);
        }

        // 4. Create Meetings
        $pastMeeting = Meeting::create([
            'committee_id' => $board->id,
            'title' => 'Q1 Strategy Review',
            'description' => 'Reviewing the performance of the first quarter.',
            'start_time' => now()->subDays(30)->setTime(10, 0),
            'end_time' => now()->subDays(30)->setTime(12, 0),
            'location' => 'Boardroom A',
            'status' => 'completed',
        ]);

        $activeMeeting = Meeting::create([
            'committee_id' => $board->id,
            'title' => 'Monthly Governance Update',
            'description' => 'Discussing new policies and upcoming resolutions.',
            'start_time' => now()->addDays(7)->setTime(14, 0),
            'end_time' => now()->addDays(7)->setTime(16, 0),
            'location' => 'Virtual / Zoom',
            'status' => 'scheduled',
        ]);

        // 5. Create Resolutions
        Resolution::create([
            'agenda_item_id' => null,
            'committee_id' => $board->id,
            'title' => 'Approval of Annual Budget',
            'legally_binding_text' => 'The board hereby approves the proposed budget for the upcoming fiscal year.',
            'state' => 'approved',
            'is_circular' => false,
        ]);

        Resolution::create([
            'agenda_item_id' => null,
            'committee_id' => $board->id,
            'title' => 'New Remote Work Policy',
            'legally_binding_text' => 'All employees are allowed to work remotely up to 3 days a week.',
            'state' => 'voting',
            'is_circular' => true,
            'voting_deadline' => now()->addDays(3),
        ]);

        Resolution::create([
            'agenda_item_id' => null,
            'committee_id' => $audit->id,
            'title' => 'External Auditor Selection',
            'legally_binding_text' => 'We propose to appoint KPMG as our external auditor.',
            'state' => 'draft',
            'is_circular' => false,
        ]);
    }
}
