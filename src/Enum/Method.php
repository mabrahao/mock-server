<?php

namespace mabrahao\MockServer\Enum;

use MyCLabs\Enum\Enum;

/**
 * @method static self GET()
 * @method static self POST()
 * @method static self PUT()
 * @method static self PATCH()
 * @method static self DELETE()
 */
class Method extends Enum
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';
}
