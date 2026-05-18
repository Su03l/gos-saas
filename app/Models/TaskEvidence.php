<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskEvidence extends Model
{
    use HasUuids;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'task_evidences';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'execution_task_id',
        'file_path',
        'notes',
    ];

    /**
     * Get the execution task that the evidence belongs to.
     */
    public function executionTask(): BelongsTo
    {
        return $this->belongsTo(ExecutionTask::class);
    }
}
