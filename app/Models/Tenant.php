<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class Tenant extends Model
{
    use Billable, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'domain',
        'sqlite_database_path',
        'logo_path',
        'primary_color',
        'secondary_color',
        'watermark_template',
        'max_users',
        'max_storage_mb',
        'subscription_status',
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
            'max_users' => 'integer',
            'max_storage_mb' => 'integer',
            'trial_ends_at' => 'datetime',
        ];
    }
}
