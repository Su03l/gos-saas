<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\ExecutionTask;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExecutionTaskController extends Controller
{
    /**
     * Display a listing of assigned tasks.
     */
    public function index(): View
    {
        $tasks = ExecutionTask::where('assignee_id', auth()->id())
            ->with('resolution')
            ->latest()
            ->get();

        return view('tenant.tasks.index', compact('tasks'));
    }

    /**
     * Submit evidence for a task.
     */
    public function submitEvidence(Request $request, ExecutionTask $task): RedirectResponse
    {
        $request->validate([
            'evidence' => ['required', 'file', 'max:5120'],
            'notes' => ['nullable', 'string'],
        ]);

        $task->evidences()->create([
            'file_path' => $request->file('evidence')->store('evidence', 'private'),
            'notes' => $request->notes,
        ]);

        $task->update(['status' => 'evidence_submitted']);

        return redirect()->back()->with('success', 'Evidence submitted successfully.');
    }
}
