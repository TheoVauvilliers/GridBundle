<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Query;

use Doctrine\ORM\QueryBuilder;
use TheoVauvilliers\GridBundle\Entity\GridDefinition;

interface QueryPartBuilderInterface
{
    public const string INVALID_VALUE_EXCEPTION_MESSAGE = 'The value "%s" is invalid for the "%s" parameter.';

    /** @param array<string, mixed> $params */
    public function build(QueryBuilder $queryBuilder, GridDefinition $definition, array $params = []): void;

    /**
     * Used to check if $definition has the data required to build.
     */
    public function supports(GridDefinition $definition): bool;
}
