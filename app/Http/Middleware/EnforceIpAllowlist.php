<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceIpAllowlist
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = session('tenant');

        if (! $tenant || ! $tenant->allowed_ips) {
            return $next($request);
        }

        $allowedIps = is_array($tenant->allowed_ips) 
            ? $tenant->allowed_ips 
            : json_decode($tenant->allowed_ips, true);

        if (empty($allowedIps)) {
            return $next($request);
        }

        if (! in_array($request->ip(), $allowedIps, true)) {
            abort(403, 'Access Restricted to Corporate Network');
        }

        return $next($request);
    }
}
