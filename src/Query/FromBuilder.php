<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Query;

use Doctrine\ORM\QueryBuilder;
use TheoVauvilliers\GridBundle\Entity\GridDefinition;
use TheoVauvilliers\GridBundle\Entity\GridDefinitionFrom;

class FromBuilder implements QueryPartBuilderInterface
{
    /** @param array<string, mixed> $params */
    public function build(QueryBuilder $queryBuilder, GridDefinition $definition, array $params = []): void
    {
        /** @var GridDefinitionFrom $from */
        $from = $definition->getSource()?->getFrom();

        $entityClass = $from->getEntity();
        $alias = $from->getAlias();

        if (null === $entityClass) {
            throw new \InvalidArgumentException(\sprintf(static::INVALID_VALUE_EXCEPTION_MESSAGE, $entityClass, 'entity'));
        }

        if (null === $alias) {
            throw new \InvalidArgumentException(\sprintf(static::INVALID_VALUE_EXCEPTION_MESSAGE, $entityClass, 'entity'));
        }

        $queryBuilder->from(
            $entityClass,
            $alias
        );
    }

    public function supports(GridDefinition $definition): bool
    {
        return null !== $definition->getSource()?->getFrom();
    }
}
