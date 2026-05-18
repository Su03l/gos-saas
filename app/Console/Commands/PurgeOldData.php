<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

#[Signature('app:purge-old-data')]
#[Description('Automatically purge data (audit logs, deleted tenant records) older than 10 years for GDPR/Enterprise compliance.')]
class PurgeOldData extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenYearsAgo = now()->subYears(10);

        $this->info("Starting data purge for records older than: " . $tenYearsAgo->toDateString());

        // 1. Purge Audit Logs (using Spatie Activitylog model)
        $deletedActivity = Activity::where('created_at', '<', $tenYearsAgo)->delete();
        $this->info("Purged {$deletedActivity} audit log entries.");

        // 2. Purge archived tenant records older than 10 years
        $deletedArchivedTenants = DB::table('tenants')
            ->where('subscription_status', 'archived')
            ->where('updated_at', '<', $tenYearsAgo)
            ->delete();
            
        $this->info("Purged {$deletedArchivedTenants} archived tenant records.");

        $this->info('Data purge complete.');
    }
}
