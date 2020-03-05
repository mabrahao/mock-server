<?php

namespace Mabrahao\MockServer\Matchers\Body;

use Mabrahao\MockServer\Model\Body;

class StringBodyMatcher implements BodyMatcherInterface
{
    /** @var BodyMatcherInterface */
    private $nextMatcher;

    public function __construct(BodyMatcherInterface $nextMatcher)
    {
        $this->nextMatcher = $nextMatcher;
    }

    public function matches($actual, Body $condition): bool
    {
        if ($actual === $condition) {
            return true;
        }

        return $this->nextMatcher->matches($actual, $condition);
    }
}
