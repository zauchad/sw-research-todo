<?php

declare(strict_types=1);

namespace SwResearch\Application\Command;

class CreateTodoCommand
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly int $position
    ) {
    }

    public function id() : string
    {
        return $this->id;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function position() : int
    {
        return $this->position;
    }
}
