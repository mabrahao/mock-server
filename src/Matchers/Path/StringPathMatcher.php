<?php

namespace Mabrahao\MockServer\Matchers\Path;

class StringPathMatcher implements PathMatcherInterface
{
    /** @var PathMatcherInterface */
    private $nextMatcher;

    /**
     * PathRegexMatcher constructor.
     * @param PathMatcherInterface $nextMatcher
     */
    public function __construct(PathMatcherInterface $nextMatcher)
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
