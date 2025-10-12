<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Query;

use Doctrine\ORM\QueryBuilder;
use TheoVauvilliers\GridBundle\Entity\GridDefinition;
use TheoVauvilliers\GridBundle\Entity\GridDefinitionSelect;

class SelectBuilder implements QueryPartBuilderInterface
{
    public function build(QueryBuilder $queryBuilder, GridDefinition $definition, array $params = []): void
    {
        /** @var GridDefinitionSelect[] $selects */
        $selects = $definition->getSource()?->getSelect();

        $selectWithAlias = array_map(
            static::generateAlias(...),
            $selects,
        );

        $queryBuilder->select(implode(', ', $selectWithAlias));
    }

    public function supports(GridDefinition $definition): bool
    {
        return null !== $definition->getSource()?->getSelect();
    }

    protected static function generateAlias(GridDefinitionSelect $definitionSelect): string
    {
        if (null === $definitionSelect->getName()) {
            throw new \InvalidArgumentException(\sprintf(static::INVALID_VALUE_EXCEPTION_MESSAGE, $definitionSelect->getName(), 'name'));
        }

        if (null === $definitionSelect->getAlias()) {
            throw new \InvalidArgumentException(\sprintf(static::INVALID_VALUE_EXCEPTION_MESSAGE, $definitionSelect->getAlias(), 'alias'));
        }

        return \sprintf('%s AS %s', $definitionSelect->getName(), $definitionSelect->getAlias());
    }
}
