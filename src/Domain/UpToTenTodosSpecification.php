<?php

declare(strict_types=1);

namespace SwResearch\Domain;

class UpToTenTodosSpecification
{
    public function __construct(private readonly TodoInterface $todos)
    {
    }

    public function isSatisfied() : bool
    {
        return $this->todos->countAll() < 10;
    }
}
