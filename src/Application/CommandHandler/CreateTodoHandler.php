<?php

declare(strict_types=1);

namespace SwResearch\Application\CommandHandler;

use Ramsey\Uuid\Uuid;
use SwResearch\Application\Command\CreateTodoCommand;
use SwResearch\Domain\Todo;
use SwResearch\Domain\TodoInterface;

class CreateTodoHandler
{
    public function __construct(
        private readonly TodoInterface $todos
    ) {}

    public function __invoke(CreateTodoCommand $command) : void
    {
        $this->todos->persist(
            new Todo(
                Uuid::fromString($command->id()),
                $command->name(),
                $command->position()
            )
        );
    }
}
