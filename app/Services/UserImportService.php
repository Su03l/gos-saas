<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\Tenant;
use App\Mail\WelcomeTenantUserMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Spatie\SimpleExcel\SimpleExcelReader;

class UserImportService
{
    /**
     * Import users from a CSV/Excel file for a specific tenant.
     */
    public function importUsers(string $filePath, Tenant $tenant): void
    {
        SimpleExcelReader::create($filePath)
            ->getRows()
            ->each(function (array $row) use ($tenant) {
                // Generate a secure random password
                $temporaryPassword = Str::random(16);

                $user = User::create([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'password' => Hash::make($temporaryPassword),
                    'tenant_id' => $tenant->id,
                    'role' => $row['role'] ?? 'member',
                ]);

                // Assign role if Spatie Permissions is used
                if (isset($row['role'])) {
                    $user->assignRole($row['role']);
                }

                // Dispatch Welcome Email with login credentials
                // Mail::to($user->email)->queue(new WelcomeTenantUserMail($user, $temporaryPassword));
            });
    }
}
