<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Exception;

class MicrosoftGraphService
{
    /**
     * Sync a SaaS meeting directly into a user's corporate Outlook calendar.
     * 
     * @param Meeting $meeting The meeting to sync
     * @param User $user The user whose calendar should be updated
     * @throws Exception If the sync fails
     */
    public function syncMeeting(Meeting $meeting, User $user): bool
    {
        $token = $user->azure_token; // Assuming the user has a stored OAuth token from SSO

        if (! $token) {
            throw new Exception("User has no active Microsoft Graph API token.");
        }

        $response = Http::withToken($token)
            ->post('https://graph.microsoft.com/v1.0/me/events', [
                'subject' => $meeting->title,
                'body' => [
                    'contentType' => 'HTML',
                    'content' => $meeting->description ?? 'No description provided.',
                ],
                'start' => [
                    'dateTime' => $meeting->scheduled_start->toIso8601String(),
                    'timeZone' => config('app.timezone', 'UTC'),
                ],
                'end' => [
                    'dateTime' => $meeting->scheduled_end->toIso8601String(),
                    'timeZone' => config('app.timezone', 'UTC'),
                ],
                'location' => [
                    'displayName' => $meeting->location ?? 'Board Portal',
                ],
                'attendees' => $meeting->members->map(fn($member) => [
                    'emailAddress' => [
                        'address' => $member->email,
                        'name' => $member->name,
                    ],
                    'type' => 'required',
                ])->toArray(),
            ]);

        if ($response->successful()) {
            return true;
        }

        throw new Exception("Microsoft Graph API Sync failed: " . $response->body());
    }
}
