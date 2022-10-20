<?php

declare(strict_types=1);

namespace SwResearch\Tests\Unit\Domain\Mother;

use Ramsey\Uuid\Uuid;
use SwResearch\Domain\Todo;
use SwResearch\Domain\TodoInterface;
use SwResearch\Domain\UpToTenTodosSpecification;
use SwResearch\Infrastructure\Database\InMemory\InMemoryTodo;

class TodoMother
{
    public static function create(string $name, ?TodoInterface $todos = null): Todo
    {
        return new Todo(
            Uuid::uuid4(),
            $name,
            random_int(0, 100),
            new UpToTenTodosSpecification($todos ?? new InMemoryTodo())
        );
    }
}
