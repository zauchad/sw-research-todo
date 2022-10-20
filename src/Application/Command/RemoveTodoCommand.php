<?php

declare(strict_types=1);

namespace SwResearch\Application\Command;

class RemoveTodoCommand
{
    public function __construct(
        private readonly string $id,
    ) {
    }

    public function id() : string
    {
        return $this->id;
    }
}
