<?php

declare(strict_types=1);

namespace TheoVauvilliers\GridBundle\Constant;

class GridDefinitionJoinTypeConstant
{
    public const string INNER = 'inner';

    public const string LEFT = 'left';

    public const array TYPES = [
        self::INNER,
        self::LEFT,
    ];
}
