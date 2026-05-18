<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\ExecutionTask;
use App\Models\Resolution;
use App\Services\AiSummarizationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Exception;

class ExtractActionItemsWithAiJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Resolution $resolution
    ) {}

    /**
     * Execute the job.
     */
    public function handle(AiSummarizationService $aiService): void
    {
        try {
            $actionItems = $this->extractFromAi($this->resolution->legally_binding_text);

            foreach ($actionItems as $item) {
                ExecutionTask::create([
                    'resolution_id' => $this->resolution->id,
                    'assignee_id' => $item['assignee_id'] ?? 1, // Default or heuristic
                    'task_description' => $item['description'],
                    'sla_deadline' => now()->addDays(7), // Suggested deadline
                    'status' => 'pending',
                ]);
            }
        } catch (Exception $e) {
            // Handle error or log
        }
    }

    /**
     * Extract structured action items from AI.
     */
    protected function extractFromAi(string $text): array
    {
        $response = Http::withToken(config('services.ai.key'))
            ->post(config('services.ai.url'), [
                'prompt' => "Extract a JSON list of action items from this text. Each item should have 'description' and optionally an 'assignee_id' if mentioned:\n\n{$text}",
                'format' => 'json',
            ]);

        if ($response->successful()) {
            return $response->json('action_items') ?? [];
        }

        return [];
    }
}
