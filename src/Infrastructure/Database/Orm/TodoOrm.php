<?php

declare(strict_types=1);

namespace SwResearch\Infrastructure\Database\Orm;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use SwResearch\Domain\Todo;
use SwResearch\Domain\TodoInterface;

class TodoOrm implements TodoInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager) {}

    public function persist(Todo $todo) : void
    {
        $this->entityManager->persist($todo);
    }

    public function remove(Todo $todo): void
    {
        $this->entityManager->remove($todo);
    }

    public function getAll(): array
    {
        return $this
            ->getRepository()
            ->findAll();
    }

    private function getRepository() : EntityRepository
    {
        return $this
            ->entityManager
            ->getRepository(Todo::class);
    }
}
