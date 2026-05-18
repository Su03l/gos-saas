<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class UnresolvedConflictOfInterestException extends Exception
{
    /**
     * Create a new exception instance.
     */
    public function __construct(string $message = 'A conflict of interest has been declared or is unresolved, preventing access.')
    {
        parent::__construct($message);
    }
}
