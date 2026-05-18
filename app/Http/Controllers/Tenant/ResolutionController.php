<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Resolution;
use App\Services\VotingEngineService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResolutionController extends Controller
{
    public function __construct(
        protected VotingEngineService $votingService
    ) {}

    /**
     * Display a listing of resolutions.
     */
    public function index(): View
    {
        $resolutions = Resolution::latest()->paginate(10);

        return view('tenant.resolutions.index', compact('resolutions'));
    }

    /**
     * Store a newly created resolution.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'committee_id' => ['required', 'exists:committees,id'],
            'agenda_item_id' => ['nullable', 'exists:agenda_items,id'],
            'title' => ['required', 'string', 'max:255'],
            'legally_binding_text' => ['required', 'string'],
            'is_circular' => ['required', 'boolean'],
            'voting_deadline' => ['nullable', 'date'],
        ]);

        $resolution = Resolution::create($validated);

        return redirect()->route('resolutions.show', $resolution)
            ->with('success', 'Resolution created successfully.');
    }

    /**
     * Display the specified resolution.
     */
    public function show(Resolution $resolution): View
    {
        $resolution->load(['committee', 'votes.user']);

        return view('tenant.resolutions.show', compact('resolution'));
    }

    /**
     * Cast a vote for the resolution.
     */
    public function castVote(Request $request, Resolution $resolution): RedirectResponse
    {
        $request->validate([
            'vote' => ['required', 'string', 'in:approve,reject,abstain'],
        ]);

        try {
            $this->votingService->castVote(
                $resolution,
                auth()->user(),
                $request->vote,
                $request->ip()
            );

            // Re-calculate result after each vote for immediate feedback if all voted
            $this->votingService->calculateResult($resolution);

            return redirect()->back()->with('success', 'Vote cast successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
