<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Transformer;

interface EntityTransformerInterface
{
    public function transform(object &$data): void;
}
