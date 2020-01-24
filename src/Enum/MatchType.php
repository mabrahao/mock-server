<?php

namespace mabrahao\MockServer\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self STRICT()
 * @method static self CONTAINS()
 */
class MatchType extends Enum
{
    const STRICT = 'STRICT';
    const CONTAINS = 'CONTAINS';
}
