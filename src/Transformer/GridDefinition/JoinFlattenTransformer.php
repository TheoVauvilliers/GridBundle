<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Transformer\GridDefinition;

use TheoVauvilliers\GridBundle\Constant\GridDefinitionJoinTypeConstant;
use TheoVauvilliers\GridBundle\Transformer\TransformerInterface;

class JoinFlattenTransformer implements TransformerInterface
{
    /**
     * whether to preserve the associative keys in the result.
     */
    protected bool $preserveKeys = false;

    /**
     * whether to skip non-array rows or throw an exception.
     */
    protected bool $skipInvalid = true;

    /**
     * @param array<int|string, mixed>|object $root
     *
     * @return array<int|string, mixed>
     */
    public function transform(mixed $data, string $path, array|object $root): array
    {
        $result = [];

        foreach ($data as $type => $joins) {
            if (!is_array($joins)) {
                if ($this->skipInvalid) {
                    continue;
                }

                throw new \InvalidArgumentException(\sprintf('Expected all values to be arrays, got %s for key "%s".', gettype($joins), $type));
            }

            if (!\in_array($type, GridDefinitionJoinTypeConstant::TYPES)) {
                continue;
            }

            foreach ($joins as $key => $join) {
                if (!is_array($join)) {
                    if ($this->skipInvalid) {
                        continue;
                    }

                    throw new \InvalidArgumentException(\sprintf('Expected all values to be arrays, got %s for key "%s".', gettype($join), $key));
                }

                $join['type'] = $type;

                if ($this->preserveKeys) {
                    $result[$type] = $join;
                } else {
                    $result[] = $join;
                }
            }
        }

        return $result;
    }
}
