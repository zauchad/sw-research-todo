<?php

declare(strict_types=1);

namespace SwResearch\Infrastructure;

use Assert\Assertion as BaseAssertion;
use SwResearch\Domain\Exception\DomainInvalidAssertionException;

class DomainAssertion extends BaseAssertion
{
    protected static $exceptionClass = DomainInvalidAssertionException::class;
}
