<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Serializer;

use TheoVauvilliers\GridBundle\Entity\GridDefinition;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface as SymfonyDenormalizerInterface;

readonly class GridDefinitionDenormalizer implements DenormalizerInterface
{
    public function __construct(
        private SymfonyDenormalizerInterface $serializer,
    ) {
    }

    /**
     * @throws ExceptionInterface
     */
    public function denormalize(array $data): GridDefinition
    {
        $definition = $this->serializer->denormalize($data, GridDefinition::class);

        if (!$definition instanceof GridDefinition) {
            throw new \UnexpectedValueException(\sprintf(static::DENORMALIZED_FAILED, GridDefinition::class));
        }

        return $definition;
    }
}
