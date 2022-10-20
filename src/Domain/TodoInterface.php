<?php

declare(strict_types=1);

namespace SwResearch\Domain;

use Ramsey\Uuid\UuidInterface;

interface TodoInterface
{
    public function getById(UuidInterface $id) : Todo;

    public function persist(Todo $todo) : void;

    public function remove(UuidInterface $id) : void;

    /**
     * @return Todo[]
     */
    public function getAll() : array;

    public function countAll() : int;
}
