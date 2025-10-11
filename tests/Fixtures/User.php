<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Tests\Fixtures;

class User
{
    /** @param array<string,mixed> $meta */
    public function __construct(
        private string $name,
        private Address $address,
        private array $meta = [],
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    /** @return array<string,mixed> */
    public function getMeta(): array
    {
        return $this->meta;
    }

    /** @param array<string,mixed> $meta */
    public function setMeta(array $meta): void
    {
        $this->meta = $meta;
    }
}
