<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\AgendaItem;
use App\Models\Meeting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    /**
     * Store a newly created agenda item in storage.
     */
    public function store(Request $request, Meeting $meeting): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'allocated_minutes' => ['required', 'integer', 'min:0'],
            'order_index' => ['required', 'integer', 'min:0'],
        ]);

        $meeting->agendaItems()->create($validated);

        return redirect()->route('meetings.show', $meeting)
            ->with('success', 'Agenda item added successfully.');
    }

    /**
     * Update the specified agenda item in storage.
     */
    public function update(Request $request, AgendaItem $agendaItem): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'allocated_minutes' => ['required', 'integer', 'min:0'],
            'order_index' => ['required', 'integer', 'min:0'],
        ]);

        $agendaItem->update($validated);

        return redirect()->route('meetings.show', $agendaItem->meeting_id)
            ->with('success', 'Agenda item updated successfully.');
    }

    /**
     * Remove the specified agenda item from storage.
     */
    public function destroy(AgendaItem $agendaItem): RedirectResponse
    {
        $meetingId = $agendaItem->meeting_id;
        $agendaItem->delete();

        return redirect()->route('meetings.show', $meetingId)
            ->with('success', 'Agenda item deleted successfully.');
    }
}
