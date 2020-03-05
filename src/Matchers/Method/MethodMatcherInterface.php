<?php

namespace Mabrahao\MockServer\Matchers\Method;

interface MethodMatcherInterface
{
    public function matches(string $actual, string $condition): bool;
}
