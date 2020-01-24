<?php

namespace mabrahao\MockServer\Matchers\Body;

use mabrahao\MockServer\Model\Body;

interface BodyMatcherInterface
{
    public function matches($actual, Body $condition): bool;
}