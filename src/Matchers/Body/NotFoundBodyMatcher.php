<?php

namespace Mabrahao\MockServer\Matchers\Body;

use Mabrahao\MockServer\Model\Body;

class NotFoundBodyMatcher implements BodyMatcherInterface
{
    public function matches($actual, Body $condition): bool
    {
        return false;
    }
}
