<?php

namespace mabrahao\MockServer\Matchers\Method;

class StringMethodMatcher implements MethodMatcherInterface
{
    /** @var MethodMatcherInterface */
    private $nextMatcher;

    /**
     * MethodRegexMatcher constructor.
     * @param MethodMatcherInterface $nextMatcher
     */
    public function __construct(MethodMatcherInterface $nextMatcher)
    {
        $this->nextMatcher = $nextMatcher;
    }

    public function matches(string $actual, string $condition): bool
    {
        if ($actual === $condition) {
            return true;
        }

        return $this->nextMatcher->matches($actual, $condition);
    }
}
