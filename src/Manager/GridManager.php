<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Manager;

use TheoVauvilliers\GridBundle\Entity\GridResult;
use TheoVauvilliers\GridBundle\Factory\GridDefinitionFactory;
use TheoVauvilliers\GridBundle\Factory\GridQueryBuilderFactory;

readonly class GridManager
{
    public function __construct(
        private GridDefinitionFactory $definitionFactory,
        private GridQueryBuilderFactory $queryBuilderFactory,
    ) {
    }

    /**
     * @param array<string, mixed> $params
     *
     * @throws \Exception
     */
    public function getGrid(string $name, array $params = []): GridResult
    {
        $definition = $this->definitionFactory->create($name);
        $queryBuilder = $this->queryBuilderFactory->create($definition, $params);

        return new GridResult($definition, $queryBuilder->getQuery()->getResult());
    }
}
