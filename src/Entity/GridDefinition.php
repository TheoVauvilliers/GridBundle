<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Entity;

class GridDefinition
{
    private string $name;

    private string $label = '';

    private GridDefinitionSource $source;

    /** @var GridDefinitionAction[] */
    private array $actions = [];

    /** @var GridDefinitionColumn[] */
    private array $columns = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getSource(): GridDefinitionSource
    {
        return $this->source;
    }

    public function setSource(GridDefinitionSource $source): static
    {
        $this->source = $source;

        return $this;
    }

    /** @return GridDefinitionColumn[] */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /** @param GridDefinitionColumn[] $columns */
    public function setColumns(array $columns): static
    {
        $this->columns = $columns;

        return $this;
    }

    /** @return GridDefinitionAction[] */
    public function getActions(): array
    {
        return $this->actions;
    }

    /** @param GridDefinitionAction[] $actions */
    public function setActions(array $actions): static
    {
        $this->actions = $actions;

        return $this;
    }
}
