<?php

declare(strict_types=1);

namespace SwResearch\Domain;

interface TodoInterface
{
    public function persist(Todo $todo) : void;

    public function remove(Todo $todo) : void;

    /**
     * @return Todo[]
     */
    public function getAll() : array;
}
