<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Factory;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use TheoVauvilliers\GridBundle\Entity\GridDefinition;
use TheoVauvilliers\GridBundle\Provider\GridDefinitionProvider;
use TheoVauvilliers\GridBundle\Transformer\GridDefinitionTransformer;

readonly class GridDefinitionFactory
{
    public function __construct(
        private GridDefinitionProvider $definitionProvider,
        private DenormalizerInterface $serializer,
    ) {
    }

    /**
     * @throws ExceptionInterface
     * @throws \Exception
     */
    public function create(string $name): GridDefinition
    {
        $definition = $this->definitionProvider->getDefinition($name);
        $definition = GridDefinitionTransformer::transformBeforeDenormalize($definition);

        $definition = $this->serializer->denormalize($definition, GridDefinition::class);

        if (!$definition instanceof GridDefinition) {
            throw new \UnexpectedValueException(\sprintf('Unable to create "%s" for "%s".', GridDefinition::class, $name));
        }

        return $definition;
    }
}
