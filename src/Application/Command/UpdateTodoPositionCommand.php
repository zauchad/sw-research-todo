<?php

declare(strict_types=1);

namespace SwResearch\Application\Command;

class UpdateTodoPositionCommand
{
    public function __construct(
        private readonly string $id,
        private readonly int $position
    ) {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function position(): int
    {
        return $this->position;
    }
}
