<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\CoiDeclaration;
use App\Models\Meeting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CoiController extends Controller
{
    /**
     * Show the COI declaration form.
     */
    public function create(Meeting $meeting): View
    {
        return view('tenant.coi.declare', compact('meeting'));
    }

    /**
     * Store a new COI declaration.
     */
    public function store(Request $request, Meeting $meeting): RedirectResponse
    {
        $request->validate([
            'has_conflict' => ['required', 'boolean'],
            'conflict_reason' => ['nullable', 'string', 'required_if:has_conflict,1'],
        ]);

        CoiDeclaration::create([
            'user_id' => auth()->id(),
            'meeting_id' => $meeting->id,
            'has_conflict' => $request->has_conflict,
            'conflict_reason' => $request->conflict_reason,
            'declared_at' => now(),
        ]);

        return redirect()->route('meetings.show', $meeting)
            ->with('success', 'Conflict of Interest declaration submitted.');
    }
}
