<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ExecutionTask;
use App\Models\Meeting;
use App\Models\Resolution;
use Illuminate\Support\Collection;

class GlobalSearchService
{
    /**
     * Search across Meetings, Resolutions, and Tasks within the isolated Tenant DB.
     *
     * @return array{meetings: Collection, resolutions: Collection, tasks: Collection}
     */
    public function search(string $keyword): array
    {
        $term = "%{$keyword}%";

        return [
            'meetings' => Meeting::where('title', 'LIKE', $term)->limit(10)->get(),
            'resolutions' => Resolution::where('title', 'LIKE', $term)
                ->orWhere('legally_binding_text', 'LIKE', $term)
                ->limit(10)
                ->get(),
            'tasks' => ExecutionTask::where('task_description', 'LIKE', $term)->limit(10)->get(),
        ];
    }
}
