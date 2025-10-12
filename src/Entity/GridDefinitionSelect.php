<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Entity;

class GridDefinitionSelect
{
    private ?string $name = null;

    private ?string $alias = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

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
