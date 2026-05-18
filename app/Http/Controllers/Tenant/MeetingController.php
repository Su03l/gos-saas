<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Committee;
use App\Models\Meeting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MeetingController extends Controller
{
    /**
     * Display a listing of the meetings.
     */
    public function index(): View
    {
        $meetings = Meeting::with('committee')->latest()->paginate(10);

        return view('tenant.meetings.index', compact('meetings'));
    }

    /**
     * Show the form for creating a new meeting.
     */
    public function create(): View
    {
        $committees = Committee::where('is_active', true)->get();

        return view('tenant.meetings.create', compact('committees'));
    }

    /**
     * Store a newly created meeting in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'committee_id' => ['required', 'exists:committees,id'],
            'title' => ['required', 'string', 'max:255'],
            'scheduled_start' => ['required', 'date'],
            'scheduled_end' => ['required', 'date', 'after:scheduled_start'],
            'meeting_link' => ['nullable', 'url'],
        ]);

        $meeting = Meeting::create($validated);

        return redirect()->route('meetings.show', $meeting)
            ->with('success', 'Meeting scheduled successfully.');
    }

    /**
     * Display the specified meeting.
     */
    public function show(Meeting $meeting): View
    {
        $meeting->load(['committee', 'agendaItems.media']);

        return view('tenant.meetings.show', compact('meeting'));
    }
}
