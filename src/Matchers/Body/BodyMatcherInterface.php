<?php

namespace mabrahao\MockServer\Matchers\Body;

interface BodyMatcherInterface
{
    public function matches($actual, $condition): bool;
}