<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Transformer;

class GridDefinitionTransformer
{
    /**
     * @param array<string, mixed> $data
     *
     * @return array<string, mixed>
     */
    public static function transformBeforeDenormalize(array $data): array
    {
        // Transform columns to add the associative key to each row
        if (isset($data['columns']) && is_array($data['columns'])) {
            $data['columns'] = new AddKeyToRowsTransformer()($data['columns'], 'name');
        }

        // Transform select to an array of arrays with name and alias
        if (isset($data['source']['select']) && is_array($data['source']['select'])) {
            $data['source']['select'] = new ParseSelectTransformer()($data['source']['select']);
        }

        if (isset($data['actions']) && \is_array($data['actions'])) {
            $data['actions'] = new AddKeyToRowsTransformer()($data['actions'], 'name');
        }

        return $data;
    }
}
