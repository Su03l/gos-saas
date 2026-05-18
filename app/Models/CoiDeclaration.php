<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoiDeclaration extends Model
{
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'meeting_id',
        'agenda_item_id',
        'has_conflict',
        'conflict_reason',
        'declared_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'has_conflict' => 'boolean',
            'declared_at' => 'datetime',
        ];
    }

    /**
     * Get the user that made the declaration.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the meeting the declaration is for.
     */
    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    /**
     * Get the agenda item the declaration is for.
     */
    public function agendaItem(): BelongsTo
    {
        return $this->belongsTo(AgendaItem::class);
    }
}
