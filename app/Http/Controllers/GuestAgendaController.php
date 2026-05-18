<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AgendaItem;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuestAgendaController extends Controller
{
    /**
     * Display the agenda item for an external advisor via a signed URL.
     */
    public function show(Request $request, AgendaItem $agendaItem): View
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'The link is invalid or has expired.');
        }

        $agendaItem->load(['meeting.committee', 'media']);

        return view('guest.agenda-view', compact('agendaItem'));
    }
}
