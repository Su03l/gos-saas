<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'manage_tenants',
            'manage_vdr',
            'view_vdr',
            'manage_meetings',
            'view_meetings',
            'manage_resolutions',
            'cast_vote',
            'declare_coi',
            'manage_tasks',
            'execute_tasks',
            'view_audit_logs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions

        // Super Admin
        $superAdmin = Role::create(['name' => 'Super_Admin']);
        // Super Admin gets all permissions via a gate (usually handled in AuthServiceProvider)
        // but we can also assign them explicitly here if preferred.
        $superAdmin->givePermissionTo(Permission::all());

        // Tenant Admin
        $tenantAdmin = Role::create(['name' => 'Tenant_Admin']);
        $tenantAdmin->givePermissionTo([
            'manage_vdr',
            'view_vdr',
            'manage_meetings',
            'view_meetings',
            'manage_resolutions',
            'manage_tasks',
            'view_audit_logs',
        ]);

        // Secretary
        $secretary = Role::create(['name' => 'Secretary']);
        $secretary->givePermissionTo([
            'manage_vdr',
            'view_vdr',
            'manage_meetings',
            'view_meetings',
            'manage_resolutions',
            'manage_tasks',
        ]);

        // Board Member
        $boardMember = Role::create(['name' => 'Board_Member']);
        $boardMember->givePermissionTo([
            'view_vdr',
            'view_meetings',
            'cast_vote',
            'declare_coi',
        ]);

        // Execution Manager
        $executionManager = Role::create(['name' => 'Execution_Manager']);
        $executionManager->givePermissionTo([
            'view_vdr',
            'view_meetings',
            'execute_tasks',
        ]);
    }
}
