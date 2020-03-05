<?php

namespace Mabrahao\MockServer\Matchers\Path;

class NotFoundPathMatcher implements PathMatcherInterface
{
    public function matches(string $actual, string $condition): bool
    {
        return false;
    }
}
