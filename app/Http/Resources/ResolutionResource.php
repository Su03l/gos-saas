<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResolutionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->legally_binding_text,
            'status' => $this->state,
            'is_circular' => (bool) $this->is_circular,
            'voting_deadline' => $this->voting_deadline?->toIso8601String(),
            'committee' => [
                'id' => $this->committee_id,
                'name' => $this->whenLoaded('committee', fn() => $this->committee->name),
            ],
            'tasks' => $this->whenLoaded('executionTasks', function () {
                return $this->executionTasks->map(fn($task) => [
                    'id' => $task->id,
                    'description' => $task->task_description,
                    'deadline' => $task->sla_deadline->toDateString(),
                    'status' => $task->status,
                    'assignee' => [
                        'name' => $task->assignee->name,
                        'email' => $task->assignee->email,
                    ],
                ]);
            }),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
