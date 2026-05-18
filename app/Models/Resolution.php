<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resolution extends Model
{
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'agenda_item_id',
        'committee_id',
        'title',
        'legally_binding_text',
        'state',
        'is_circular',
        'voting_deadline',
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
            'is_circular' => 'boolean',
            'voting_deadline' => 'datetime',
        ];
    }

    /**
     * Get the agenda item associated with the resolution.
     */
    public function agendaItem(): BelongsTo
    {
        return $this->belongsTo(AgendaItem::class);
    }

    /**
     * Get the committee the resolution belongs to.
     */
    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }

    /**
     * Get the votes for the resolution.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }
}
