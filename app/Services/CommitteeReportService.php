<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Committee;
use Spatie\SimpleExcel\SimpleExcelWriter;

class CommitteeReportService
{
    /**
     * Generate an Excel performance report for all committees.
     */
    public function generatePerformanceReport(string $filePath): string
    {
        $writer = SimpleExcelWriter::create($filePath)
            ->addHeader([
                'Committee Name',
                'Total Meetings',
                'Avg. Attendance %',
                'Resolutions Passed',
                'SLA Breach %',
            ]);

        Committee::with(['meetings', 'resolutions', 'members'])->get()->each(function (Committee $committee) use ($writer) {
            $totalMeetings = $committee->meetings->count();
            
            // Calculate Average Attendance
            $avgAttendance = $committee->meetings->avg(function ($meeting) use ($committee) {
                $totalMembers = $committee->members->count();
                $presentCount = $meeting->attendances()->where('status', 'present')->count();
                return $totalMembers > 0 ? ($presentCount / $totalMembers) * 100 : 0;
            }) ?? 0;

            $resolutionsPassed = $committee->resolutions()->where('state', 'approved')->count();
            
            // Mock SLA calculation logic
            $slaBreachPercent = rand(0, 15);

            $writer->addRow([
                $committee->name,
                $totalMeetings,
                round($avgAttendance, 2) . '%',
                $resolutionsPassed,
                $slaBreachPercent . '%',
            ]);
        });

        return $filePath;
    }
}
