<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Entity;

class GridDefinitionFrom
{
    /** @var ?class-string */
    private ?string $entity = null;

    private ?string $alias = null;

    /** @return ?class-string */
    public function getEntity(): ?string
    {
        return $this->entity;
    }

    /** @param ?class-string $entity */
    public function setEntity(?string $entity): static
    {
        $this->entity = $entity;

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
}
