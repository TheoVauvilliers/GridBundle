<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Transformer;

interface TransformerInterface
{
    /**
     * @param array<int|string, mixed>|object $root
     */
    public function transform(mixed $data, string $path, array|object $root): mixed;
}
