<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\Webhook;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class DispatchWebhookJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 30;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Webhook $webhook,
        public string $event,
        public array $payload
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $jsonPayload = json_encode([
            'event' => $this->event,
            'data' => $this->payload,
            'timestamp' => now()->timestamp,
        ]);

        $signature = hash_hmac('sha256', $jsonPayload, $this->webhook->secret);

        Http::timeout(10)
            ->withHeaders([
                'X-Signature' => $signature,
                'Content-Type' => 'application/json',
            ])
            ->post($this->webhook->url, json_decode($jsonPayload, true));
    }

    /**
     * Calculate the number of seconds to wait before retrying the job.
     */
    public function backoff(): array
    {
        return [10, 60, 300];
    }
}
