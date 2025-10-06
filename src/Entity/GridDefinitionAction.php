<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Entity;

class GridDefinitionAction
{
    private string $name;

    private string $label;

    private string $route;

    /** @var array<string, string> */
    private array $routeParameters = [];

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function setRoute(string $route): static
    {
        $this->route = $route;

        return $this;
    }

    public function getRouteParameters(): array
    {
        return $this->routeParameters;
    }

    public function setRouteParameters(array $routeParameters): static
    {
        $this->routeParameters = $routeParameters;

        return $this;
    }
}
