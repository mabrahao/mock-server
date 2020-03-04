<?php

namespace mabrahao\MockServer\Matchers\Body;

use mabrahao\MockServer\Model\Body;

class NotFoundBodyMatcher implements BodyMatcherInterface
{
    public function matches($actual, Body $condition): bool
    {
        return false;
    }
}
