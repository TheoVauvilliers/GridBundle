<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Transformer;

/**
 * Transforms an array of select strings into GridDefinitionSelect objects.
 *
 * Handles both formats:
 * - "f.name" → name='f.name', alias='name'
 * - "f.name as custom_alias" → name='f.name', alias='custom_alias'
 */
class ParseSelectTransformer
{
    /**
     * @param string[] $selects
     *
     * @return array<int, array{name: string, alias: string}>
     */
    public function __invoke(array $selects): array
    {
        return array_map(fn (string $select): array => $this->parse($select), $selects);
    }

    /** @return array{name: string, alias: string} */
    private function parse(string $select): array
    {
        $select = trim($select);

        if (preg_match('/^(.+?)\s+as\s+(\w+)$/i', $select, $matches)) {
            $name = trim($matches[1]);
            $alias = trim($matches[2]);
        } else {
            $name = $select;
            $alias = $this->generateAlias($select);
        }

        return [
            'name' => $name,
            'alias' => $alias,
        ];
    }

    /**
     * Generates an alias from a field name.
     * Examples:
     * - "f.id" → "id"
     * - "f.name" → "name"
     * - "f.configName" → "configName".
     */
    private function generateAlias(string $fieldName): string
    {
        $fieldName = trim($fieldName);

        if (str_contains($fieldName, '.')) {
            $parts = explode('.', $fieldName);

            return end($parts);
        }

        return $fieldName;
    }
}
