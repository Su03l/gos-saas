<?php

declare(strict_types=1);

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Queue;
use Exception;

class HealthCheckController extends Controller
{
    /**
     * Perform a system health check.
     */
    public function __invoke(): JsonResponse
    {
        $status = [
            'database' => $this->checkDatabase(),
            'redis' => $this->checkRedis(),
            'queue' => $this->checkQueue(),
        ];

        $isHealthy = ! in_array(false, array_values($status), true);

        return response()->json([
            'status' => $isHealthy ? 'healthy' : 'unhealthy',
            'services' => $status,
        ], $isHealthy ? 200 : 503);
    }

    /**
     * Check database connection.
     */
    private function checkDatabase(): bool
    {
        try {
            DB::connection()->getPdo();
            return true;
        } catch (Exception) {
            return false;
        }
    }

    /**
     * Check Redis connection.
     */
    private function checkRedis(): bool
    {
        try {
            // Only check if redis is not disabled in env
            if (config('database.redis.default.host') === null) {
                return true;
            }
            Redis::connection()->ping();
            return true;
        } catch (Exception) {
            // If redis is not configured or fails, we might still consider it okay if it's not a hard dependency
            // But for this task, we assume it's part of the health check.
            return false;
        }
    }

    /**
     * Check if queue worker is likely active.
     * For database queue, we can check if there are many old pending jobs.
     */
    private function checkQueue(): bool
    {
        try {
            // Simple check: can we connect to the queue?
            Queue::connection()->size();
            return true;
        } catch (Exception) {
            return false;
        }
    }
}
