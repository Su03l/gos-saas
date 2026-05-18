<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\MissingCoiDeclarationException;
use App\Models\AgendaItem;
use App\Models\CoiDeclaration;
use App\Models\User;

class CoiValidationService
{
    /**
     * Determine if a user can view a document based on COI declarations.
     *
     * @throws MissingCoiDeclarationException
     */
    public function canViewDocument(User $user, AgendaItem $item): bool
    {
        $declaration = CoiDeclaration::where('user_id', $user->id)
            ->where('meeting_id', $item->meeting_id)
            ->where(function ($query) use ($item) {
                $query->where('agenda_item_id', $item->id)
                    ->orWhereNull('agenda_item_id');
            })
            ->latest('declared_at')
            ->first();

        if (! $declaration) {
            throw new MissingCoiDeclarationException("A Conflict of Interest declaration is missing for user [{$user->name}] and agenda item [{$item->title}].");
        }

        return ! $declaration->has_conflict;
    }
}
