<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Transformer\GridDefinition;

use TheoVauvilliers\GridBundle\Transformer\AbstractAddKeyToRowsTransformer;

class ActionsKeyTransformer extends AbstractAddKeyToRowsTransformer
{
    protected function getKeyColumnName(): string
    {
        return 'name';
    }
}
