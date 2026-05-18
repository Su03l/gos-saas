<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Meeting;
use Illuminate\Support\Facades\Http;
use Exception;

class AiSummarizationService
{
    /**
     * Summarize a meeting using AI.
     */
    public function summarizeMeeting(Meeting $meeting): string
    {
        $contentToSummarize = $meeting->agendaItems->map(function ($item) {
            return "Agenda: {$item->title}. Description: {$item->description}";
        })->implode("\n");

        if (empty($contentToSummarize)) {
            $contentToSummarize = "Meeting: {$meeting->title}. Description: {$meeting->description}";
        }

        try {
            return $this->callAiApi($contentToSummarize);
        } catch (Exception $e) {
            return "Summary unavailable at this time.";
        }
    }

    /**
     * Abstract the AI API call.
     */
    protected function callAiApi(string $content): string
    {
        // Placeholder for external AI API call (e.g., Gemini or OpenAI)
        $response = Http::withToken(config('services.ai.key'))
            ->post(config('services.ai.url'), [
                'prompt' => "Summarize the following meeting notes into exactly 3 bullet points:\n\n{$content}",
                'max_tokens' => 150,
            ]);

        if ($response->successful()) {
            return $response->json('summary') ?? $response->json('choices.0.text') ?? "No summary generated.";
        }

        throw new Exception("AI API call failed: " . $response->body());
    }
}
