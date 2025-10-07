<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Factory;

use TheoVauvilliers\GridBundle\Entity\GridDefinition;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;

readonly class GridQueryBuilderFactory
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /** @param array<string, mixed> $params */
    public function create(GridDefinition $definition, array $params): QueryBuilder
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder
            ->from(
                $definition->getSource()->getFrom()->getEntity(),
                $definition->getSource()->getFrom()->getAlias()
            )
            ->select($this->buildSelect($definition))
        ;

        return $queryBuilder;
    }

    private function buildSelect(GridDefinition $definition): string
    {
        $select = array_map(
            static fn ($select) => \sprintf('%s AS %s', $select->getName(), $select->getAlias()),
            $definition->getSource()->getSelect()
        );

        return implode(', ', $select);
    }
}
