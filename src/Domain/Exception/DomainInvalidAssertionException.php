<?php

declare(strict_types=1);

namespace SwResearch\Domain\Exception;

class DomainInvalidAssertionException extends DomainInvalidArgumentException
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
