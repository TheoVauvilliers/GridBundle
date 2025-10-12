<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Entity;

class GridDefinitionJoin
{
    private ?string $type = null;

    private ?string $join = null;

    private ?string $alias = null;

    private ?string $conditionType = null;

    private ?string $condition = null;

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getJoin(): ?string
    {
        return $this->join;
    }

    public function setJoin(?string $join): static
    {
        $this->join = $join;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): static
    {
        $this->alias = $alias;

        return $this;
    }

    public function getConditionType(): ?string
    {
        return $this->conditionType;
    }

    public function setConditionType(?string $conditionType): static
    {
        $this->conditionType = $conditionType;

        return $this;
    }

    public function getCondition(): ?string
    {
        return $this->condition;
    }

    public function setCondition(?string $condition): static
    {
        $this->condition = $condition;

        return $this;
    }
}
