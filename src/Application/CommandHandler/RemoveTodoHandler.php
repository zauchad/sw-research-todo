<?php

declare(strict_types=1);

namespace SwResearch\Application\CommandHandler;

use Ramsey\Uuid\Uuid;
use SwResearch\Application\Command\RemoveTodoCommand;
use SwResearch\Domain\TodoInterface;

class RemoveTodoHandler
{
    public function __construct(
        private readonly TodoInterface $todos
    ) {
    }

    public function __invoke(RemoveTodoCommand $command) : void
    {
        $this->todos->remove(Uuid::fromString($command->id()));
    }
}
