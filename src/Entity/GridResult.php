<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Entity;

readonly class GridResult
{
    /** @param array<int, mixed> $result */
    public function __construct(
        private GridDefinition $definition,
        private array $result,
    ) {
    }

    public function getDefinition(): GridDefinition
    {
        return $this->definition;
    }

    /** @return array<int, mixed> */
    public function getResult(): array
    {
        return $this->result;
    }
}
