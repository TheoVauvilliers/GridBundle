<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Entity;

class GridDefinitionSource
{
    /** @var GridDefinitionSelect[] */
    private array $select = [];

    private ?GridDefinitionFrom $from = null;

    /** @var array<int|string, GridDefinitionJoin> */
    private array $join = [];

    /** @return GridDefinitionSelect[] */
    public function getSelect(): array
    {
        return $this->select;
    }

    /** @param GridDefinitionSelect[] $select */
    public function setSelect(array $select): static
    {
        $this->select = $select;

        return $this;
    }

    public function getFrom(): ?GridDefinitionFrom
    {
        return $this->from;
    }

    public function setFrom(?GridDefinitionFrom $from): static
    {
        $this->from = $from;

        return $this;
    }

    /** @return GridDefinitionJoin[] */
    public function getJoin(): array
    {
        return $this->join;
    }

    /** @param GridDefinitionJoin[] $join */
    public function setJoin(array $join): static
    {
        $this->join = $join;

        return $this;
    }
}
