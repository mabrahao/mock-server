<?php

namespace mabrahao\MockServer\Matchers\Body;

class NotFoundBodyMatcher implements BodyMatcherInterface
{
    public function matches($actual, $condition): bool
    {
        return false;
    }
}
