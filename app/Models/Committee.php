<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Committee extends Model
{
    use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'charter_description',
        'quorum_percentage',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'string',
            'quorum_percentage' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    /**
     * The members that belong to the committee.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'committee_members')
            ->withPivot('role_in_committee')
            ->withTimestamps();
    }

    /**
     * Get the meetings for the committee.
     */
    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class);
    }
}
