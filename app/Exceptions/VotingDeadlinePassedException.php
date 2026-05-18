<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class VotingDeadlinePassedException extends Exception
{
    /**
     * Create a new exception instance.
     */
    public function __construct(string $message = 'The voting deadline for this resolution has already passed.')
    {
        parent::__construct($message);
    }
}
