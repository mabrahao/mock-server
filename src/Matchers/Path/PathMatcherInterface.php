<?php

namespace Mabrahao\MockServer\Matchers\Path;

interface PathMatcherInterface
{
    public function matches(string $actual, string $condition): bool;
}