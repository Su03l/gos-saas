<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Tenant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ArchiveTenantDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Tenant $tenant)
    {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $archiveName = "archives/tenant_{$this->tenant->id}_" . now()->format('Ymd') . ".zip";
        $zipPath = storage_path("app/private/{$archiveName}");

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // 1. Archive the SQLite Database
            $dbPath = $this->tenant->sqlite_database_path;
            if (file_exists($dbPath)) {
                $zip->addFile($dbPath, 'database.sqlite');
            }

            // 2. Archive Media/Storage files
            $tenantStoragePath = "tenants/{$this->tenant->id}";
            $files = Storage::disk('private')->allFiles($tenantStoragePath);

            foreach ($files as $file) {
                $zip->addFile(Storage::disk('private')->path($file), "storage/{$file}");
            }

            $zip->close();

            // 3. Move ZIP to Cold Storage (e.g., S3 Glacier bucket)
            // Storage::disk('s3_glacier')->put($archiveName, file_get_contents($zipPath));
            
            // 4. Cleanup Active Files
            if (file_exists($dbPath)) {
                // unlink($dbPath); // CAUTION: Only uncomment in production after testing
            }
            // Storage::disk('private')->deleteDirectory($tenantStoragePath);
            
            // Update Tenant Status
            $this->tenant->update(['subscription_status' => 'archived']);
        }
    }
}
