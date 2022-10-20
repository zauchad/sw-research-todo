<?php

declare(strict_types=1);

namespace SwResearch\Infrastructure\Database\Orm;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\UuidInterface;
use SwResearch\Domain\Todo;
use SwResearch\Domain\TodoInterface;
use SwResearch\Infrastructure\Exception\InfrastructureRuntimeException;

class TodoOrm implements TodoInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager) {}

    public function persist(Todo $todo) : void
    {
        $this->entityManager->persist($todo);
    }

    public function getById(UuidInterface $id): Todo
    {
        $item = $this->getRepository()->find($id);

        if ($item === null) {
            throw new InfrastructureRuntimeException(sprintf('Todo not found by id %s', $id));
        }

        return $item;
    }

    public function remove(UuidInterface $id): void
    {
        $todo = $this->getRepository()->find($id);
        $this->entityManager->remove($todo);
    }

    public function getAll(): array
    {
        return $this
            ->getRepository()
            ->findAll();
    }

    public function countAll(): int
    {
        return $this
            ->getRepository()
            ->createQueryBuilder('t')
            ->select('COUNT(t.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    private function getRepository() : EntityRepository
    {
        return $this
            ->entityManager
            ->getRepository(Todo::class);
    }
}
