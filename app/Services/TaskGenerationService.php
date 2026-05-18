<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ExecutionTask;
use App\Models\Resolution;
use Illuminate\Support\Collection;

class TaskGenerationService
{
    /**
     * Generate execution tasks from an approved resolution.
     *
     * @param  array<int, array{assignee_id: int, description: string, deadline: string}>  $assignments
     * @return Collection<int, ExecutionTask>
     */
    public function generateTasksFromResolution(Resolution $resolution, array $assignments): Collection
    {
        if ($resolution->state !== 'approved') {
            throw new \RuntimeException('Tasks can only be generated from approved resolutions.');
        }

        return collect($assignments)->map(function (array $data) use ($resolution) {
            return ExecutionTask::create([
                'resolution_id' => $resolution->id,
                'assignee_id' => $data['assignee_id'],
                'task_description' => $data['description'],
                'sla_deadline' => $data['deadline'],
                'status' => 'pending',
            ]);
        });
    }
}
