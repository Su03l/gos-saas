<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ExecutionTask;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ReportExportService
{
    /**
     * Stream a large execution tracking report to Excel with Arabic headers.
     */
    public function exportExecutionTasks(): void
    {
        $writer = SimpleExcelWriter::streamDownload('execution_report.xlsx');

        // Add Arabic Headers
        $writer->addRow([
            'المهمة',
            'المسؤول',
            'الحالة',
            'الموعد النهائي',
            'القرار المرتبط',
        ]);

        ExecutionTask::with(['assignee', 'resolution'])
            ->chunk(100, function ($tasks) use ($writer) {
                foreach ($tasks as $task) {
                    $writer->addRow([
                        $task->task_description,
                        $task->assignee->name,
                        __($task->status),
                        $task->sla_deadline->format('Y-m-d'),
                        $task->resolution->title,
                    ]);
                }
            });

        $writer->toBrowser();
    }
}
