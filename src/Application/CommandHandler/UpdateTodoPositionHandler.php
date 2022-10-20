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
    ) {
    }

    public function __invoke(UpdateTodoPositionCommand $command) : void
    {
        $todo = $this->todos->getById(Uuid::fromString($command->id()));
        $oldPosition = $todo->position();
        $newPosition = $command->position();

        foreach ($this->todos->getAll() as $t) {
            if ($t->position() >= $oldPosition && $newPosition >= $t->position() && $t->position() > 0) {
                $t->updatePosition(
                    $t->position() - 1
                );
            }

            if ($t->position() <= $oldPosition && $newPosition <= $t->position() && $t->position() < 9) {
                $t->updatePosition(
                    $t->position() + 1
                );
            }
        }

        $todo->updatePosition($command->position());
    }
}
