<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommitteeMember extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'committee_id',
        'user_id',
        'role_in_committee',
    ];

    /**
     * Get the committee that the member belongs to.
     */
    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class);
    }

    /**
     * Get the user that is a member of the committee.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
