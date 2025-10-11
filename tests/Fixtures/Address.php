<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Tests\Fixtures;

class Address
{
    public function __construct(
        private string $city,
    ) {
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }
}
