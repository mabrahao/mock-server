<?php

namespace Mabrahao\MockServer\Matchers\Header;

interface HeaderMatcherInterface
{
    public function matches(array $expectationHeaders, array $serverData): bool;
}