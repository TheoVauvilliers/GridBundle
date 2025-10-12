<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Factory;

use TheoVauvilliers\GridBundle\Entity\GridDefinition;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use TheoVauvilliers\GridBundle\Query\QueryPartBuilderInterface;

readonly class GridQueryBuilderFactory
{
    /** @param iterable<QueryPartBuilderInterface> $queryPartBuilders */
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected iterable $queryPartBuilders,
    ) {
    }

    /** @param array<string, mixed> $params */
    public function create(GridDefinition $definition, array $params): QueryBuilder
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        foreach ($this->queryPartBuilders as $queryPartBuilder) {
            if ($queryPartBuilder->supports($definition)) {
                $queryPartBuilder->build($queryBuilder, $definition, $params);
            }
        }

        return $queryBuilder;
    }
}
