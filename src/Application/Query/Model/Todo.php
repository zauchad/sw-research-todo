<?php

declare(strict_types=1);

namespace SwResearch\Application\Query\Model;

use DateTimeImmutable;
use JsonSerializable;

class Todo implements JsonSerializable
{
    public function __construct(
        private readonly string $id,
        private DateTimeImmutable $createdAt,
        private string $name,
        private int $position,
    ) {
    }

    public function id() : string
    {
        return $this->id;
    }

    public function createdAt() : DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function position() : int
    {
        return $this->position;
    }

    public function jsonSerialize() : mixed
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->createdAt,
            'name' => $this->name,
            'position' => $this->position,
        ];
    }
}
