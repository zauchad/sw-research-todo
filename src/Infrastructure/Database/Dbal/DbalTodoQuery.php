<?php

declare(strict_types=1);

namespace SwResearch\Infrastructure\Database\Dbal;

use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use SwResearch\Application\Query\Model\Todo;
use SwResearch\Application\Query\TodoQueryInterface;

class DbalTodoQuery implements TodoQueryInterface
{
    public function __construct(private readonly Connection $connection) {}

    public function getAll(): array
    {
        $queryBuilder = $this->getHydratedQueryBuilder();

        $results = $this->connection->fetchAllAssociative(
            $queryBuilder->getSQL(),
            $queryBuilder->getParameters(),
            $queryBuilder->getParameterTypes()
        );

        return array_map(
            fn (array $result) => $this->hydrate($result),
            $results
        );
    }

    public function getLastPosition(): int
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('MAX(position)')
            ->from('todos', 't');

        $result = $this->connection->fetchOne(
            $queryBuilder->getSQL(),
            $queryBuilder->getParameters(),
            $queryBuilder->getParameterTypes()
        );

        return $result ?? -1;
    }

    public function getById(string $id): Todo
    {
        $queryBuilder = $this->getHydratedQueryBuilder()
            ->andWhere('t.id = :id')
            ->setParameter('id', $id);

        $result = $this->connection->fetchAssociative(
            $queryBuilder->getSQL(),
            $queryBuilder->getParameters(),
            $queryBuilder->getParameterTypes()
        );

        return $this->hydrate($result);
    }

    public function getByPosition(int $position): Todo
    {
        $queryBuilder = $this->getHydratedQueryBuilder()
            ->andWhere('t.position = :position')
            ->setParameter('position', $position);

        $result = $this->connection->fetchAssociative(
            $queryBuilder->getSQL(),
            $queryBuilder->getParameters(),
            $queryBuilder->getParameterTypes()
        );

        dd($position, $result);

        return $this->hydrate($result);
    }

    private function getHydratedQueryBuilder() : QueryBuilder {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder
            ->select('*')
            ->from('todos', 't')
            ->orderBy('position', 'ASC');

        return $queryBuilder;
    }

    private function hydrate(array $result) : Todo
    {
        return new Todo(
            $result['id'],
            new DateTimeImmutable($result['created_at']),
            $result['name'],
            $result['position'],
        );
    }
}
