<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meeting extends Model
{
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'committee_id',
        'title',
        'scheduled_start',
        'scheduled_end',
        'meeting_link',
        'status',
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
            'scheduled_start' => 'datetime',
            'scheduled_end' => 'datetime',
        ];
    }

    /**
     * Get the committee that owns the meeting.
     */
    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }

    /**
     * Get the agenda items for the meeting.
     */
    public function agendaItems(): HasMany
    {
        return $this->hasMany(AgendaItem::class);
    }
}
