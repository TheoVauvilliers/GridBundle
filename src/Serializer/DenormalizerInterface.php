<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Serializer;

interface DenormalizerInterface
{
    public const string DENORMALIZED_FAILED = 'Failed to denormalize "%s.';

    /** @param array<string, mixed> $data */
    public function denormalize(array $data): object;
}
