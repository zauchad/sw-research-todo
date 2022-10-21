<?php

declare(strict_types=1);

namespace SwResearch\Domain;

use DateTimeImmutable;
use Ramsey\Uuid\UuidInterface;
use SwResearch\Infrastructure\DomainAssertion;

class Todo
{
    private DateTimeImmutable $createdAt;
    private string $name;

    public function __construct(
        private readonly UuidInterface $id,
        string $name,
        private int $position,
        UpToTenTodosSpecification $upToTenTodosSpecification
    ) {
        DomainAssertion::true(
            $upToTenTodosSpecification->isSatisfied(),
            'You can add up to 10 TODO\'s'
        );
        DomainAssertion::notEmpty(trim($name), "Name can't be empty");
        DomainAssertion::maxLength(
            trim($name),
            150,
            "Name length can't exceed 150 characters"
        );

        $this->name = trim($name);
        $this->createdAt = new DateTimeImmutable();
    }

    public function updateName(string $name)
    {
        DomainAssertion::notEmpty(trim($name), "Name can't be empty");
        DomainAssertion::maxLength(
            trim($name),
            150,
            "Name length can't exceed 150 characters"
        );

        $this->name = $name;
    }

    public function updatePosition(int $position)
    {
        $this->position = $position;
    }

    public function id() : UuidInterface
    {
        return $this->id;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function position() : int
    {
        return $this->position;
    }

    public function createdAt() : DateTimeImmutable
    {
        return $this->createdAt;
    }
}
