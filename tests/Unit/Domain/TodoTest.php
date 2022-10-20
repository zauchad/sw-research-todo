<?php

namespace SwResearch\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use SwResearch\Domain\Exception\DomainInvalidAssertionException;
use SwResearch\Domain\Todo;
use SwResearch\Infrastructure\Database\InMemory\InMemoryTodo;
use SwResearch\Tests\Unit\Domain\Mother\TodoMother;

class TodoTest extends TestCase
{
    public function testCreatingTodo()
    {
        $todo = TodoMother::create($name = 'Clean the house');

        self::assertInstanceOf(Todo::class, $todo);
        self::assertEquals($todo->name(), $name);
        self::assertNotNull($todo->createdAt());
    }

    public function testUpdateTodoName()
    {
        $todo = TodoMother::create('Drive car back to the office');
        $todo->updateName($name = 'Updated TODO');
        self::assertEquals($name, $todo->name());
    }

    public function testUpdatePosition()
    {
        $todo = TodoMother::create('Buy flower');
        $todo->updatePosition($position = 13);
        self::assertEquals($position, $todo->position());
    }

    public function testShouldThrowExceptionWhenCreatingTodoWithEmptyName()
    {
        $this->expectExceptionObject(
            new DomainInvalidAssertionException('Name can\'t be empty')
        );

        TodoMother::create(name: '');
    }

    public function testShouldThrowExceptionWhenCreatingTodoWithTooLongName()
    {
        $this->expectExceptionObject(
            new DomainInvalidAssertionException('Name length can\'t exceed 150 characters')
        );

        TodoMother::create(name: str_repeat('N', 151));
    }

    public function testShouldThrowExceptionWhenUpdatingTodoWithTooLongName()
    {
        $this->expectExceptionObject(
            new DomainInvalidAssertionException('Name length can\'t exceed 150 characters')
        );

        $todo = TodoMother::create(name: 'Example todo name');
        $todo->updateName(str_repeat('N', 151));
    }

    public function testShouldThrowExceptionWhenCreatingMoreThanTenTodos()
    {
        $this->expectExceptionObject(
            new DomainInvalidAssertionException('You can add up to 10 TODO\'s')
        );

        $todos = new InMemoryTodo();

        for ($i = 0; $i <= 10; ++$i) {
            $todos->persist(
                TodoMother::create('Buy flower'.$i, $todos)
            );
        }
    }
}
