<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('viewPulse', function (User $user) {
            return $user->hasRole('Super_Admin');
        });

        RateLimiter::for('enterprise_api', function (Request $request) {
            $tenant = session('tenant');
            
            // Default to Starter limits if no tenant or plan is found
            $limit = ($tenant && $tenant->plan === 'Enterprise') ? 1000 : 100;

            return Limit::perMinute($limit)->by($tenant?->id ?: $request->ip());
        });
    }
}
