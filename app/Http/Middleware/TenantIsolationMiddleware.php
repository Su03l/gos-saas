<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Exceptions\TenantDatabaseNotFoundException;
use App\Models\Tenant;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TenantIsolationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
        $user = $request->user();
        $tenantId = $user?->tenant_id ?? session('tenant_id');

        if (! $tenantId) {
            return $next($request);
        }

        $tenant = Tenant::find($tenantId);

        if (! $tenant) {
            return $next($request);
        }

        if (! session()->has('tenant')) {
            session(['tenant' => $tenant]);
        }

        $databasePath = $tenant->sqlite_database_path;

        if (! file_exists($databasePath)) {
            throw new TenantDatabaseNotFoundException("The database for tenant [{$tenant->name}] was not found at: {$databasePath}");
        }

        // Clone sqlite connection to tenant
        $config = Config::get('database.connections.sqlite');
        $config['database'] = $databasePath;
        Config::set('database.connections.tenant', $config);

        // Purge and reconnect
        DB::purge('tenant');
        DB::setDefaultConnection('tenant');

        return $next($request);
    }
}
