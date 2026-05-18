<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DataExportController extends Controller
{
    /**
     * Export all data related to the authenticated user into a ZIP file.
     */
    public function export(Request $request)
    {
        $user = $request->user();
        $data = [
            'profile' => [
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at->toDateTimeString(),
            ],
            'votes' => $user->votes()->with('resolution:id,title')->get()->map(fn($vote) => [
                'resolution' => $vote->resolution->title,
                'decision' => $vote->type,
                'timestamp' => $vote->created_at->toDateTimeString(),
            ]),
            'tasks' => $user->tasks()->get()->map(fn($task) => [
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'due_date' => $task->due_date?->toDateTimeString(),
            ]),
            'committees' => $user->committees()->pluck('name'),
        ];

        $jsonContent = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $fileName = "export_user_{$user->id}_" . now()->format('YmdHis') . ".zip";
        $zipPath = storage_path("app/private/{$fileName}");

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            $zip->addFromString('user_data.json', $jsonContent);
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
