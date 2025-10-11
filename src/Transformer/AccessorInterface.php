<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Transformer;

interface AccessorInterface
{
    /**
     * @param array<int|string, mixed>|object $from
     */
    public function get(array|object $from, string $path): mixed;

    /**
     * @param array<int|string, mixed>|object $into
     */
    public function set(array|object &$into, string $path, mixed $value): void;
}
