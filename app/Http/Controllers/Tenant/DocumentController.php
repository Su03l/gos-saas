<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Jobs\ApplyWatermarkToDocumentJob;
use App\Models\AgendaItem;
use App\Services\CoiValidationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DocumentController extends Controller
{
    public function __construct(
        protected CoiValidationService $coiService
    ) {}

    /**
     * Store a newly uploaded document for an agenda item.
     */
    public function store(Request $request, AgendaItem $agendaItem): RedirectResponse
    {
        $request->validate([
            'document' => ['required', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $agendaItem->addMediaFromRequest('document')
            ->toMediaCollection('confidential_documents');

        return redirect()->back()->with('success', 'Document uploaded successfully.');
    }

    /**
     * Display the watermarked document if COI is cleared.
     */
    public function show(Media $media): StreamedResponse|RedirectResponse
    {
        /** @var AgendaItem $agendaItem */
        $agendaItem = $media->model;

        try {
            if (! $this->coiService->canViewDocument(auth()->user(), $agendaItem)) {
                return redirect()->back()->with('error', 'Access denied due to Conflict of Interest.');
            }
        } catch (\Exception $e) {
            return redirect()->route('coi.create', $agendaItem->meeting_id)
                ->with('warning', 'Please declare your Conflict of Interest before viewing this document.');
        }

        // Dispatch watermark job (In a real app, we'd wait or use a temporary signed URL)
        // For this task, we stream the original or a mock watermarked file
        ApplyWatermarkToDocumentJob::dispatch(
            $media,
            auth()->user()->name,
            request()->ip()
        );

        return Storage::disk('private')->download($media->getPath());
    }
}
