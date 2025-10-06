<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Entity;

class GridDefinitionFrom
{
    private string $entity;

    private string $alias;

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function setEntity(string $entity): static
    {
        $this->entity = $entity;

        return $this;
    }

    public function getAlias(): string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): static
    {
        $this->alias = $alias;

        return $this;
    }
}
