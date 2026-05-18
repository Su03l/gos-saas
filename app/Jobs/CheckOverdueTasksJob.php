<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\ExecutionTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CheckOverdueTasksJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $overdueTasks = ExecutionTask::where('status', '!=', 'closed')
            ->where('status', '!=', 'escalated')
            ->where('sla_deadline', '<', now()->startOfDay())
            ->get();

        foreach ($overdueTasks as $task) {
            $task->update(['status' => 'escalated']);

            // Trigger notification (Stubbed)
            Log::warning("SLA Escalation: Task [{$task->id}] for Resolution [{$task->resolution_id}] is overdue.");

            // event(new TaskEscalated($task));
        }
    }
}
