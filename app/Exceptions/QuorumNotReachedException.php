<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class QuorumNotReachedException extends Exception
{
    /**
     * Create a new exception instance.
     */
    public function __construct(string $message = 'The required quorum percentage was not reached for this resolution.')
    {
        parent::__construct($message);
    }
}
