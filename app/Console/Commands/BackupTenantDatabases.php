<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use ZipArchive;

class BackupTenantDatabases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Zip and backup all tenant SQLite databases securely.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting tenant database backup...');

        $tenants = Tenant::all();
        $backupDir = storage_path('app/backups/tenants');
        $timestamp = now()->format('Y-m-d_H-i-s');

        if (! File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $zip = new ZipArchive;
        $zipFileName = "tenants_backup_{$timestamp}.zip";
        $zipPath = "{$backupDir}/{$zipFileName}";

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            $this->error('Could not create zip file.');

            return 1;
        }

        foreach ($tenants as $tenant) {
            $dbPath = $tenant->sqlite_database_path;

            if (File::exists($dbPath)) {
                $zip->addFile($dbPath, "{$tenant->id}_{$tenant->domain}.sqlite");
                $this->line("Added database for tenant: [{$tenant->name}]");
            } else {
                $this->warn("Database not found for tenant: [{$tenant->name}] at {$dbPath}");
            }
        }

        $zip->close();

        $this->info("Backup completed successfully: {$zipPath}");

        return 0;
    }
}
