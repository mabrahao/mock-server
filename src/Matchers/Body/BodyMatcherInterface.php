<?php

namespace Mabrahao\MockServer\Matchers\Body;

use Mabrahao\MockServer\Model\Body;

interface BodyMatcherInterface
{
    public function matches($actual, Body $condition): bool;
}