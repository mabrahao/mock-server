<?php

namespace mabrahao\MockServer\Matchers\Method;

interface MethodMatcherInterface
{
    public function matches(string $actual, string $condition): bool;
}
