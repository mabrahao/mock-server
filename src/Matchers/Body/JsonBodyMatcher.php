<?php

namespace mabrahao\MockServer\Matchers\Body;

class JsonBodyMatcher implements BodyMatcherInterface
{
    /** @var BodyMatcherInterface */
    private $nextMatcher;

    public function __construct(BodyMatcherInterface $nextMatcher)
    {
        $this->nextMatcher = $nextMatcher;
    }

    public function matches($actual, $condition): bool
    {
        if (json_decode($actual) == json_decode($condition)) {
            return true;
        }

        return $this->nextMatcher->matches($actual, $condition);
    }
}
