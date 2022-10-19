<?php

declare(strict_types=1);

namespace SwResearch\Application\CommandHandler;

use Ramsey\Uuid\Uuid;
use SwResearch\Application\Command\UpdateTodoPositionCommand;
use SwResearch\Domain\TodoInterface;

class UpdateTodoPositionHandler
{
    public function __construct(
        private readonly TodoInterface $todos
    ) {}

    public function __invoke(UpdateTodoPositionCommand $command) : void
    {
        $todo = $this->todos->getById(Uuid::fromString($command->id()));
        $todo->updatePosition($command->position());
    }
}
