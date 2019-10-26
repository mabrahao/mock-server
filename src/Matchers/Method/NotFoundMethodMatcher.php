<?php

namespace mabrahao\MockServer\Matchers\Method;

class NotFoundMethodMatcher implements MethodMatcherInterface
{
    public function matches(string $actual, string $condition): bool
    {
        return false;
    }
}
