<?php

declare(strict_types=1);

namespace SwResearch\Domain;

use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;
use SwResearch\Infrastructure\DomainAssertion;

class Todo
{
    private DateTimeImmutable $createdAt;

    public function __construct(
        private readonly UuidInterface $id,
        private string $name,
        private int $position,
    ) {
        DomainAssertion::notEmpty($this->name, "Name can't be empty");
        DomainAssertion::maxLength($this->name, 150, "Name length can't exceed 150 characters");
        DomainAssertion::between($this->position, 0, 9, "Position value must be between 0 and 9");

        $this->createdAt = new DateTimeImmutable();
    }

    public function updateName(string $name) {
        DomainAssertion::notEmpty($name, "Name can't be empty");
        DomainAssertion::maxLength($name, 150, "Name length can't exceed 150 characters");

        $this->name = $name;
    }

    public function updatePosition(int $position) {
        DomainAssertion::between($position, 0, 9, "Position value must be between 0 and 9");

        $this->position = $position;
    }

    public function id(): UuidInterface
    {
        return $this->id;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
