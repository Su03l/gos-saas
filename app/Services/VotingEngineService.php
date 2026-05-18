<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Resolution;
use App\Models\User;
use App\Models\Vote;

class VotingEngineService
{
    /**
     * Cast a vote for a resolution.
     */
    public function castVote(Resolution $resolution, User $user, string $voteType, string $ip): Vote
    {
        if ($resolution->state !== 'voting') {
            throw new \RuntimeException('Voting is not active for this resolution.');
        }

        if ($resolution->voting_deadline && $resolution->voting_deadline->isPast()) {
            throw new \RuntimeException('The voting deadline has passed.');
        }

        // Check if user is in committee
        if (! $resolution->committee->members()->where('users.id', $user->id)->exists()) {
            throw new \RuntimeException('User is not a member of the committee for this resolution.');
        }

        return Vote::updateOrCreate(
            ['resolution_id' => $resolution->id, 'user_id' => $user->id],
            [
                'vote_cast' => $voteType,
                'vote_weight' => 1.0, // Default weight, could be dynamic based on role
                'ip_address' => $ip,
            ]
        );
    }

    /**
     * Calculate the result of a resolution based on votes and quorum.
     */
    public function calculateResult(Resolution $resolution): void
    {
        $committee = $resolution->committee;
        $totalMembers = $committee->members()->count();
        $votes = $resolution->votes;
        $totalVotes = $votes->count();

        $deadlinePassed = $resolution->voting_deadline && $resolution->voting_deadline->isPast();
        $allVoted = $totalVotes === $totalMembers;

        if (! $deadlinePassed && ! $allVoted) {
            return;
        }

        $quorumReached = ($totalVotes / $totalMembers) * 100 >= $committee->quorum_percentage;

        if (! $quorumReached) {
            $resolution->update(['state' => 'rejected']);

            return;
        }

        $approveWeight = $votes->where('vote_cast', 'approve')->sum('vote_weight');
        $rejectWeight = $votes->where('vote_cast', 'reject')->sum('vote_weight');

        if ($approveWeight > $rejectWeight) {
            $resolution->update(['state' => 'approved']);
        } else {
            $resolution->update(['state' => 'rejected']);
        }
    }
}
