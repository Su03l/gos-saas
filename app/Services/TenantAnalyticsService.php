<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ExecutionTask;
use App\Models\Meeting;
use App\Models\Resolution;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class TenantAnalyticsService
{
    /**
     * Get statistics for execution tasks.
     *
     * @return array{pending: int, in_progress: int, evidence_submitted: int, closed: int, escalated: int}
     */
    public function getTaskCompletionStats(): array
    {
        $tenantId = session('tenant')?->id ?? 'global';

        return Cache::tags(['tenant_'.$tenantId])->remember('task_completion_stats', 3600, function () {
            $stats = ExecutionTask::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->pluck('count', 'status')
                ->toArray();

            return [
                'pending' => (int) ($stats['pending'] ?? 0),
                'in_progress' => (int) ($stats['in_progress'] ?? 0),
                'evidence_submitted' => (int) ($stats['evidence_submitted'] ?? 0),
                'closed' => (int) ($stats['closed'] ?? 0),
                'escalated' => (int) ($stats['escalated'] ?? 0),
            ];
        });
    }

    /**
     * Get statistics for meetings and resolutions.
     *
     * @return array{upcoming_meetings: int, active_resolutions: int, approved_resolutions: int}
     */
    public function getGeneralStats(): array
    {
        $tenantId = session('tenant')?->id ?? 'global';

        return Cache::tags(['tenant_'.$tenantId])->remember('general_dashboard_stats', 3600, function () {
            return [
                'upcoming_meetings' => Meeting::where('scheduled_start', '>', now())->count(),
                'active_resolutions' => Resolution::where('state', 'voting')->count(),
                'approved_resolutions' => Resolution::where('state', 'approved')->count(),
            ];
        });
    }
}
