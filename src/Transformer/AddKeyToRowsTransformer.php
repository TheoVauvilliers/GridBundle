<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Transformer;

/**
 * Transforms an associative array of rows by adding each row's key
 * as a new column in that row.
 */
class AddKeyToRowsTransformer
{
    private bool $preserveKeys;

    private bool $skipInvalid;

    /**
     * @param bool $preserveKeys whether to preserve the associative keys in the result
     * @param bool $skipInvalid  whether to skip non-array rows or throw an exception
     */
    public function __construct(bool $preserveKeys = false, bool $skipInvalid = true)
    {
        $this->preserveKeys = $preserveKeys;
        $this->skipInvalid = $skipInvalid;
    }

    /**
     * Applies the transformation.
     *
     * @param array<string, mixed> $data associative array of rows
     * @param string $keyName the name of the column to store the array keys
     *
     * @return array<int|string, array<string, mixed>>
     *
     * @throws \InvalidArgumentException if a non-array row is found and $skipInvalid is false
     */
    public function __invoke(array $data, string $keyName): array
    {
        $result = [];

        foreach ($data as $key => $row) {
            if (!is_array($row)) {
                if ($this->skipInvalid) {
                    continue;
                }

                throw new \InvalidArgumentException(\sprintf('Expected all values to be arrays, got %s for key "%s".', gettype($row), $key));
            }

            $row[$keyName] = $key;

            if ($this->preserveKeys) {
                $result[$key] = $row;
            } else {
                $result[] = $row;
            }
        }

        return $result;
    }
}
