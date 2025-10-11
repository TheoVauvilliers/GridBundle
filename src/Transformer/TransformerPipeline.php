<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Transformer;

class TransformerPipeline
{
    public function __construct(
        protected readonly AccessorInterface $propertyAccessor,
    ) {
    }

    /** @var array<string, TransformerInterface> */
    private array $transformers = [];

    /** @var array<int, EntityTransformerInterface> */
    private array $entityTransformers = [];

    /**
     * @param array<int|string, mixed>|object $data
     */
    public function transform(array|object &$data): void
    {
        foreach ($this->transformers as $path => $transformer) {
            try {
                $value = $this->propertyAccessor->get($data, $path);

                $value = $transformer->transform($value, $path, $data);

                $this->propertyAccessor->set($data, $path, $value);
            } catch (\Throwable $e) {
                // TODO: Log error
            }
        }
    }

    public function entityTransform(object &$entity): void
    {
        foreach ($this->entityTransformers as $transformer) {
            try {
                $transformer->transform($entity);
            } catch (\Throwable $e) {
                // TODO: Log error
            }
        }
    }

    public function add(string $path, TransformerInterface $transformer): void
    {
        $this->transformers[$path] = $transformer;
    }

    public function addEntityTransformer(EntityTransformerInterface $transformer): void
    {
        $this->entityTransformers[] = $transformer;
    }
}
