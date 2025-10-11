<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Factory;

use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use TheoVauvilliers\GridBundle\Entity\GridDefinition;
use TheoVauvilliers\GridBundle\Provider\GridDefinitionProvider;
use TheoVauvilliers\GridBundle\Transformer\TransformerPipeline;

readonly class GridDefinitionFactory
{
    public function __construct(
        protected GridDefinitionProvider $definitionProvider,
        protected TransformerPipeline $transformerPipeline,
        protected DenormalizerInterface $serializer,
    ) {
    }

    /**
     * @throws ExceptionInterface
     * @throws \Exception
     */
    public function create(string $name): GridDefinition
    {
        $definition = $this->definitionProvider->getDefinition($name);
        $this->transformerPipeline->transform($definition);

        $definition = $this->serializer->denormalize($definition, GridDefinition::class);
        $this->transformerPipeline->entityTransform($definition);

        if (!$definition instanceof GridDefinition) {
            throw new \UnexpectedValueException(\sprintf('Unable to create "%s" for "%s".', GridDefinition::class, $name));
        }

        return $definition;
    }
}
