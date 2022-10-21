<?php

declare(strict_types=1);

namespace SwResearch\Infrastructure\Database\InMemory;

use Ramsey\Uuid\UuidInterface;
use SwResearch\Domain\Todo;
use SwResearch\Domain\TodoInterface;
use SwResearch\Infrastructure\Exception\InfrastructureNotFoundException;

class InMemoryTodo implements TodoInterface
{
    /**
     * @var Todo[]
     */
    private array $todos = [];

    public function persist(Todo $todo) : void
    {
        $this->todos[] = $todo;
    }

    public function getById(UuidInterface $id) : Todo
    {
        foreach ($this->todos as $todo) {
            if ($id->equals($todo->id())) {
                return $todo;
            }
        }

        throw new InfrastructureNotFoundException(
            sprintf("Todo not found by id %s", $id)
        );
    }

    public function remove(UuidInterface $id) : void
    {
        foreach ($this->todos as $index => $todo) {
            if ($id->equals($todo->id())) {
                unset($this->todos[$index]);
            }
        }
    }

    public function getAll() : array
    {
        return $this->todos;
    }

    public function countAll() : int
    {
        return count($this->todos);
    }
}
