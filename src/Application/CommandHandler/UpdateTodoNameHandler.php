<?php

declare(strict_types=1);

namespace SwResearch\Application\CommandHandler;

use Ramsey\Uuid\Uuid;
use SwResearch\Application\Command\UpdateTodoNameCommand;
use SwResearch\Domain\TodoInterface;

class UpdateTodoNameHandler
{
    public function __construct(
        private readonly TodoInterface $todos
    ) {}

    public function __invoke(UpdateTodoNameCommand $command) : void
    {
        $todo = $this->todos->getById(Uuid::fromString($command->id()));
        $todo->updateName($command->name());
    }
}
