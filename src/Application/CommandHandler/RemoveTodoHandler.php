<?php

declare(strict_types=1);

namespace SwResearch\Application\CommandHandler;

use Ramsey\Uuid\Uuid;
use SwResearch\Application\Command\RemoveTodoCommand;
use SwResearch\Domain\TodoInterface;

class RemoveTodoHandler
{
    public function __construct(private readonly TodoInterface $todos)
    {
    }

    public function __invoke(RemoveTodoCommand $command) : void
    {
        $todoToRemove = $this->todos->getById(Uuid::fromString($command->id()));
        $this->todos->remove($todoToRemove->id());

        foreach ($this->todos->getAll() as $t) {
            if ($t->id()->equals($todoToRemove->id())) {
                continue;
            }

            if ($t->position() > $todoToRemove->position()) {
                $t->updatePosition($t->position() - 1);
            }
        }
    }
}
