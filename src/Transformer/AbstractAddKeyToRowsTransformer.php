<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Transformer;

/**
 * Transforms an associative array of rows by adding each row's key
 * as a new column in that row.
 */
abstract class AbstractAddKeyToRowsTransformer implements TransformerInterface
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
     * @param array<string, mixed>|object $root
     *
     * @return array<int, mixed>
     */
    public function transform(mixed $data, string $path, array|object $root): array
    {
        $result = [];

        foreach ($data as $key => $row) {
            if (!is_array($row)) {
                if ($this->skipInvalid) {
                    continue;
                }

                throw new \InvalidArgumentException(\sprintf('Expected all values to be arrays, got %s for key "%s".', gettype($row), $key));
            }

            $row[$this->getKeyColumnName()] = $key;

            if ($this->preserveKeys) {
                $result[$key] = $row;
            } else {
                $result[] = $row;
            }
        }

        return $result;
    }

    abstract protected function getKeyColumnName(): string;
}
