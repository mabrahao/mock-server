<?php

namespace mabrahao\MockServer\Matchers\Body;

class StringBodyMatcher implements BodyMatcherInterface
{
    /** @var BodyMatcherInterface */
    private $nextMatcher;

    public function __construct(BodyMatcherInterface $nextMatcher)
    {
        $this->nextMatcher = $nextMatcher;
    }

    public function matches($actual, $condition): bool
    {
        if ($actual === $condition) {
            return true;
        }

        return $this->nextMatcher->matches($actual, $condition);
    }
}
